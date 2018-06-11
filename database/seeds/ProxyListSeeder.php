<?php

use App\Models\ProxyList;
use Illuminate\Database\Seeder;

class ProxyListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ips = [
            [
                'nome' => 'local',
                'proxy' => null,
            ],
            [
                'nome' => 'carga',
                'proxy' => 'socks5://127.0.0.1:8001',
                'deleted_at' => now()
            ],
            [
                'nome' => 'digitalocean',
                'proxy' => 'socks5://127.0.0.1:8003',
                'deleted_at' => now()
            ],
            [
                'nome' => 'redmine',
                'proxy' => 'socks5://127.0.0.1:8004',
                'deleted_at' => now()
            ],
            [
                'nome' => 'ecommerce',
                'proxy' => 'socks5://127.0.0.1:8005',
                'deleted_at' => now()
            ],
            [
                'nome' => 'captcha',
                'proxy' => 'socks5://127.0.0.1:8006',
                'deleted_at' => now()
            ]
        ];

        foreach ($ips as $ip) {
            ProxyList::create($ip);
        }
    }
}
