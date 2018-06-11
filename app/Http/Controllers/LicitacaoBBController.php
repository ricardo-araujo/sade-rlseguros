<?php

namespace App\Http\Controllers;

use App\Jobs\LicitacaoBBReceivedJob;
use App\Models\LicitacaoBB;
use Illuminate\Http\Request;

class LicitacaoBBController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic')->except('download'); //aplica autenticação apenas para quando receber do carga
    }

    public function create(Request $request)
    {
        $oportunidade = json_decode($request->get('json'), true);

        if (!$oportunidade)
            return response('Oportunidade nao recebida', 404);

        dispatch(new LicitacaoBBReceivedJob($oportunidade));

        return response('Oportunidade enviada para processamento');
    }

    public function download(LicitacaoBB $licitacao)
    {
        $zipName = "licitacao_{$licitacao->id}.zip";

        $path = public_path("/anexos/bb/{$licitacao->id}/");

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
