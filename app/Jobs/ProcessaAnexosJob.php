<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class ProcessaAnexosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var AbstractLicitacao
     */
    private $licitacao;

    /**
     * Create a new job instance.
     *
     * @param AbstractLicitacao|Model $licitacao
     */
    public function __construct(AbstractLicitacao $licitacao)
    {
        $this->licitacao = $licitacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->delete();

        Log::debug('Processando anexo da licitacao', [
            'portal' => $this->licitacao->portal,
            'licitacao' => $this->licitacao->id
        ]);

        $path = anexos_path($this->licitacao);

        beggining:
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        foreach ($it as $item) {

            if (strtolower($item->getExtension()) == 'zip') { //caso arquivo seja zip, é extraido e excluido, retornando ao 'beggining' para o caso de um haver outro zip dentro do arquivo anterior

                $zip = new \ZipArchive();
                $zip->open($item->getRealPath());
                $zip->extractTo($path);
                $zip->close();

                unlink($item->getRealPath());

                goto beggining;
            }
        }

        $files = [];
        foreach ($it as $item) {

            if ($item->getExtension() == 'zip')
                goto beggining;

            if ($item->isFile()) {
                $files[$item->getFilename()] = $item->getSize(); //cria array com chave sendo nome, e valor sendo o tamanho dos arquivos do diretorio
                rename($item->getRealPath(), $path . $item->getFilename()); //caso o arquivo atual esteja dentro de uma pasta, joga-o p/ o dir principal
            }
        }

        $collection = new Collection($files);

        if ($collection->count() === 1) {

            $name = $collection->keys()->first();

        } else {

            if ($match = $collection->sortKeysDesc()->keys()->first(function($arquivo) { //orderna os nomes dos arquivos e retorna o primeiro que satisfaz a regex abaixo

                return (bool) preg_match('#^preg.o.*|^edital.*|^pe.*|.*preg.o.*|.*edital.*#iu', $arquivo);

            })) {

                $name = $match;

            } else {

                $name = $collection->sort()->keys()->last(); //ordena pelo tamanho dos arquivos e traz o maior

            }
        }

        if (ends_with($name, ['rtf', 'RTF'])) { //verifica extensao do arquivo para transforma-lo em pdf, atraves do libreoffice (particularidade da Mapfre)

            (new Process(sprintf('soffice --headless --invisible --norestore --convert-to pdf:writer_pdf_Export --outdir %s "%s%s"', $path, $path, $name)))->run();

            $name = preg_replace('#\.rtf$#i', '.pdf', $name);
        }

        $cleanName = preg_replace(['#[^a-zA-Z0-9\-_\.]#', '#_{2,}#'], '_', $name); //normaliza o nome do arquivo

        rename($path.$name, $path.$cleanName);

        $name = $cleanName;

        $this->licitacao->update(['dt_registro_anexo' => now(), 'nm_anexo_principal' => $name]);
    }
}
