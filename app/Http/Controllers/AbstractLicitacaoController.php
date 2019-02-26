<?php

namespace App\Http\Controllers;

use App\Models\AbstractLicitacao;
use Illuminate\Http\Request;

class AbstractLicitacaoController extends Controller
{
    public function download(AbstractLicitacao $licitacao)
    {
        $zipname = "lic_{$licitacao->portal}_{$licitacao->id}.zip";

        $path = anexos_path($licitacao);

        $it = new \DirectoryIterator($path);

        $zip = new \ZipArchive();

        if ($zip->open($path . $zipname, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

            foreach ($it as $item) {
                if ($item->isFile())
                    $zip->addFile($item->getRealPath(), $item->getFilename());
            }

            $zip->close();
        }

        return response()->download($path . $zipname, $zipname)->deleteFileAfterSend();
    }
}
