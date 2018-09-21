<?php

/**
 * Arquivo para juntar funções comuns ao Sade
*/

if (!function_exists('content_from_doc')) {

    function content_from_doc($pathToFile) {

        return shell_exec("catdoc \"{$pathToFile}\"");
    }
}

if (!function_exists('content_from_docx')) {

    function content_from_docx($pathToFile) {

        $content = '';
        $zip = zip_open($pathToFile);
        if (!$zip || is_numeric($zip))
            return false;
        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry) == false)
                continue;
            if (zip_entry_name($zip_entry) != "word/document.xml")
                continue;
            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
            zip_entry_close($zip_entry);
        }
        zip_close($zip);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }
}

if (!function_exists('content_from_pdf')) {

    function content_from_pdf($pathToFile) {

        $tmpFile = '/tmp/' . md5($pathToFile) . '.txt';
        shell_exec("pdftotext $pathToFile $tmpFile -raw >/dev/null 2>&1");
        $content = file_get_contents($tmpFile);
        unlink($tmpFile);

        return $content;
    }
}

if (!function_exists('content_from_rtf')) {

    function content_from_rtf($pathToFile) {

        return shell_exec("catdoc \"{$pathToFile}\"");
    }
}

if (!function_exists('content_from_txt')) {

    function content_from_txt($pathToFile) {

        return file_get_contents($pathToFile);
    }
}

if (!function_exists('content_from_file')) {

    function content_from_file($pathToFile)
    {
        $ext = pathinfo($pathToFile, PATHINFO_EXTENSION);

        switch (mb_strtolower($ext)) {

            case 'doc':
                return content_from_doc($pathToFile);

            case 'docx':
                return content_from_docx($pathToFile);

            case 'pdf':
                return content_from_pdf($pathToFile);

            case 'rtf':
                return content_from_rtf($pathToFile);

            case 'txt':
                return content_from_txt($pathToFile);

            default:
                return false;
        }
    }
}

if (!function_exists('only_numbers')) {

    function only_numbers($string) {

        return preg_replace('#[^0-9]#', '', $string);
    }
}

if (!function_exists('cnpj_is_valid')) {

    function cnpj_is_valid($cnpj) {

        $cnpj = preg_replace('#[^0-9]#', '', (string) $cnpj);

        if (strlen($cnpj) != 14 or $cnpj == '00000000000000')
            return false;

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }
}

if (!function_exists('hour')) {

    function hour($hour = null, $minute = null, $second = null, $tz = null) {

        return \Illuminate\Support\Carbon::createFromTime($hour, $minute, $second, $tz);

    }
}

if (!function_exists('edital_path')) {

    function edital_path(\App\Models\AbstractLicitacao $licitacao) {

        $ds = DIRECTORY_SEPARATOR;

        return public_path('anexos' . $ds . $licitacao->portal . $ds . $licitacao->id . $ds . $licitacao->nm_anexo_principal);
    }
}

if (!function_exists('check_upload')) {

    function check_upload($html) {

        return (bool) preg_match('#enviado com sucesso#i', $html);

    }
}
