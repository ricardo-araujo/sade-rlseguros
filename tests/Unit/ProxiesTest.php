<?php

namespace Tests\Unit;

use App\Models\ProxyList;
use App\Repository\ProxyListRepository;
use GuzzleHttp\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProxiesTest extends TestCase
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

    public function testProxies()
    {
        $proxies = (new ProxyListRepository())->all();

        $ips = []; //inicializa uma variavel para guardar ips retornados

        $proxies->each(function(ProxyList $proxy) use(&$ips) {

            $client = new Client(['proxy' => $proxy->proxy]);

            $ip = $client->get('https://api.ipify.org')->getBody()->getContents(); //api que verifica ip da requisicao

            $this->assertNotEmpty($ip); //verifica se retornou algum ip do proxy

            $this->assertNotContains($ip, $ips, "IP retornado do proxy {$proxy->nome} já existe na lista"); //verifica se o ip atual nao é igual aos retornados anteriormente

            $ips = array_merge($ips, [$proxy->nome => $ip]);
        });
    }
}
