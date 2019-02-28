<?php

namespace App\Console\Commands;

use App\Repository\LicitacaoIORepository;
use Forseti\Bot\IO\PageObject\LicitacaoDetalhesPageObject;
use Forseti\Bot\IO\PageObject\RenderizaBoletimPageObject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Zend\Mail\Storage\Imap;

class CargaEmailIOCommand extends Command
{
    /**
     * Pasta em que deve ser verificado e-mails de oportunidades
    */
    const FOLDER_TO_READ = 'INBOX.Imprensa Oficial';

    /**
     * Pasta em que deve ser movido os e-mails verificados
     */
    const FOLDER_TO_MOVE = 'INBOX.Imprensa Oficial Lida';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sade:carga-email-io';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command para busca de oportunidades do Imprensa Oficial em uma caixa de e-mail específica';

    /**
     * @var Imap
     */
    private $imapbox;

    /**
     * @var RenderizaBoletimPageObject
     */
    private $pageObject;

    /**
     * @var LicitacaoDetalhesPageObject
     */
    private $detalhesPageObject;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Imap $imapbox, RenderizaBoletimPageObject $pageObject, LicitacaoDetalhesPageObject $detalhesPageObject)
    {
        parent::__construct();
        $this->imapbox = $imapbox;
        $this->pageObject = $pageObject;
        $this->detalhesPageObject = $detalhesPageObject;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(LicitacaoIORepository $repository)
    {
        Log::info('Iniciando busca de licitacoes do portal IO via e-mail');

        $this->imapbox->selectFolder(self::FOLDER_TO_READ);

        try {

            foreach ($this->imapbox as $email) {

                $id = get_id_from_email($email->getContent());

                $parser = $this->pageObject->get($id);

                $licitacoes = $parser->getLinksLicitacaoIterator();

                foreach ($licitacoes as $licitacao) {

                    $this->imapbox->noop();

                    $parser = $this->detalhesPageObject->get($licitacao['id_licitacao']);

                    $repository->create($parser->asArray());
                }

                $this->imapbox->moveMessage($email->key(), self::FOLDER_TO_MOVE);
            }

        } catch (\Exception $e) {

            Log::warning('Erro ao buscar licitacoes via e-mail do portal IO', ['exception' => $e->getMessage()]);

        } finally {

            $this->imapbox->close();

        }
    }
}
