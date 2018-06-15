<?php

namespace App\Http\Controllers;

use App\Models\AbstractLicitacao;
use Illuminate\Http\Request;

class AbstractLicitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('create');
        $this->middleware('auth.basic')->only('create');
    }

    public function download(AbstractLicitacao $licitacao)
    {
        $zipName = "lic_{$licitacao->portal}_{$licitacao->id}.zip";

        $path = public_path('anexos' . DIRECTORY_SEPARATOR . $licitacao->portal . DIRECTORY_SEPARATOR . $licitacao->id . DIRECTORY_SEPARATOR);

        $it = new \DirectoryIterator($path);

        $zip = new \ZipArchive();

        if ($zip->open($path . $zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

            foreach ($it as $item) {
                if ($item->isFile())
                    $zip->addFile($item->getRealPath(), $item->getFilename());
            }

            $zip->close();
        }

        return response()->download($path . $zipName, $zipName)->deleteFileAfterSend(true);
    }
}
