<?php

namespace App\Jobs;

use App\Models\AbstractLicitacao;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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

        Log::debug('Processando anexo da licitacao', ['licitacao' => $this->licitacao->toArray()]);

        $path = public_path('anexos' . DIRECTORY_SEPARATOR . $this->licitacao->portal . DIRECTORY_SEPARATOR . $this->licitacao->id . DIRECTORY_SEPARATOR);

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

        if (count($files) == 1) {

            $name = array_keys($files)[0];

        } else {

            krsort($files); //ordena pelo nome dos arquivos (chave), do maior p/ o menor

            if ($match = preg_grep('#^preg.o.*|^edital.*|.*preg.o.*|.*edital.*|^PE\s?.*|.*Seguro.*#ui', array_keys($files))) {

                $name = reset($match);

            } else {

                arsort($files); //ordena pelo tamanho dos arquivos (valor), do maior p/ o menor

                $files = array_keys($files);

                $name = reset($files);
            }
        }

        if (preg_match('#\.rtf$#i', $name)) { //verifica extensao do arquivo para transforma-lo em pdf, atraves do libreoffice (particularidade da Mapfre)

            $process = new Process(sprintf('soffice --headless --invisible --norestore --convert-to pdf:writer_pdf_Export --outdir %s "%s%s"', $path, $path, $name));

            $process->run();

            $name = preg_replace('#\.rtf$#i', '.pdf', $name);
        }

        if (preg_match('#[^a-zA-Z0-9\-_\.]#', $name)) { //normaliza o nome do arquivo

            $newName = preg_replace('#[^a-zA-Z0-9\-_\.]#', '_', $name);
            $newName = preg_replace('#_{2,}#', '_', $newName);
            rename($path.$name, $path.$newName);

            $name = $newName;
        }

        $this->licitacao->update(['dt_registro_anexo' => now(), 'nm_anexo_principal' => $name]);
    }
}
