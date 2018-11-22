<?php

namespace Tests\Unit;

use App\Models\LicitacaoBB;
use App\Models\LicitacaoCN;
use App\Models\LicitacaoIO;
use App\Models\ReservaBB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SadeHelpersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testFunctions()
    {
        $doc = content_from_doc(__DIR__ . '/resources/file.doc');
        $docx = content_from_docx(__DIR__ . '/resources/file.docx');
        $pdf = content_from_pdf(__DIR__ . '/resources/file.pdf');
        $rtf = content_from_rtf(__DIR__ . '/resources/file.rtf');
        $txt = content_from_txt(__DIR__ . '/resources/file.txt');

        $this->assertNotEmpty($doc);
        $this->assertNotEmpty($docx);
        $this->assertNotEmpty($pdf);
        $this->assertNotEmpty($rtf);
        $this->assertNotEmpty($txt);

        $it = new \DirectoryIterator(__DIR__ . '/resources');
        foreach ($it as $item) {
            if ($item->isFile())
                $this->assertNotEmpty(content_from_file($item->getPathname()));
        }

        $this->assertNotEmpty(only_numbers('abc123!@#$%*()'));
        $this->assertEmpty(only_numbers('uma frase qualquer'));

        $this->assertFalse(cnpj_is_valid('00000000000000'));
        $this->assertFalse(cnpj_is_valid('00.000.000/0000-00'));
        $this->assertFalse(cnpj_is_valid('0'));
        $this->assertNotFalse(cnpj_is_valid('16.703.759/0001-70'));
        $this->assertNotFalse(cnpj_is_valid('16703759000170'));

        $this->assertInstanceOf(\DateTime::class, hour(00, 00, 00));

        $licBBFactory = factory(LicitacaoBB::class)->make();
        $licCNFactory = factory(LicitacaoCN::class)->make();
        $licIOFactory = factory(LicitacaoIO::class)->make();

        $this->assertNotEmpty(edital_path($licBBFactory));
        $this->assertNotEmpty(edital_path($licCNFactory));
        $this->assertNotEmpty(edital_path($licIOFactory));
    }
}
