# Sistema Automatizado de Download de Editais
Projeto refatorado e baseado em Laravel, que visa identificar oportunidades e realizar download de editais dos portais [Banco do Brasil](https://www.licitacoes-e.com.br/), [Comprasnet](http://www.comprasnet.gov.br/) e [Imprensa Oficial](https://www.imprensaoficial.com.br/) e anexá-los no portal da [Mapfre](http://mapfrenegociospublicos.com.br)

## Instalação
Após preencher os arquivos de configuração (diretório config) e .env:
```
composer install
```
```
php artisan migrate --seed
```
```
sudo apt-get install catdoc pdftotext
```
## Utilização
Para visualizar os commands disponíveis, digite no terminal dentro da aplicação:
```
php artisan list sade
```

## Estrutura lógica
TODO

## Commands auxiliares
Além dos commands principais para a aplicação, foram adicionados alguns commands que auxiliam em outros processos:
- Command de backup (auto-explicativo);
- Command de geração de tokens do recaptcha, que como a aplicação antiga, gera tokens e grava-os no banco de dados para utilização no login e anexo de edital.
- Command de gerenciamento de proxies, que grava, remove, altera ou restaura um proxy. Os proxies são necessários na aplicação pois a Mapfre bloqueia tentativas de anexar edital feitas em menos de 2 minutos para um IP;
- Command para remover cookies (auto-explicativo);
- Command para enviar e-mail das oportunidades do dia;
- Command para truncar a tabela de jobs ao final do dia e remover jobs que não conseguiram ser processados;
- Command para login na Mapfre, a fim de gerar um cookie em txt para criação de órgaos do BB e IO;

**Os commands descritos nos passos acima, foram definidos utilizando o mecanismo de Task Scheduling do Laravel, para que possam funcionar, devem seguir a documentação. Ex.:**
```
No crontab:
* * * * * php /sade-cn-rl-seguro/artisan schedule:run >> /dev/null 2>&1
```
_Obs: olhar no arquivo mostrado na documentação para entender os horários que os commands funcionam._
