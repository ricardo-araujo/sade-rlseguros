<?php

namespace App\Http\Controllers;

use App\Models\LicitacaoCN;
use Illuminate\Http\Request;

class LicitacaoCNController extends Controller
{
    public function download(LicitacaoCN $licitacao)
    {
        $zipName = "licitacao_{$licitacao->id}.zip";

        $path = public_path("/anexos/cn/{$licitacao->id}/");

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