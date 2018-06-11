# Sistema Automatizado de Download de Editais
Projeto refatorado e baseado em Laravel, que visa identificar oportunidades e realizar download de editais do portal [Comprasnet](http://www.comprasnet.gov.br/) e anexá-los no portal da [Mapfre](http://mapfrenegociospublicos.com.br).

## Instalação
Após preencher os arquivos de configuração e .env:
```
composer install
```
```
php artisan migrate
```
```
php artisan db:seed
```

## Utilização
Para visualizar os commands disponíveis, digite no terminal dentro da aplicação:
```
php artisan list sade
```

## Estrutura lógica
A aplicação segue alguns passos seguindo a lógica do Sade CN antigo, são esses:
- Primeiro, há um command de carga das oportunidades do CN, que busca as oportunidades de seguro do dia, e as grava no banco de dados - caso existirem;
- Após as oportunidades capturadas, são disponibilizadas na dashboard da homepage da aplicação, para que o cliente possa atribuir reservas às oportunidades;
- Em caso de atribuição, é disparado o job de validação da reserva, que faz login na Mapfre, vai até o página da reserva e grava os parâmetros necessários, que serão utilizados na anexação do edital;
- Há o command de download de anexos, que busca as oportunidades do dia corrente, que não tiveram seus anexos baixados, e manda para o job de download;
- O job de download, por sua vez, utiliza do bot do CN para salvar os arquivos na pasta 'public/anexos/id-da-oportunidade', e manda para o job de processamento dos anexos;
- O job de processamento trata no diretório os arquivos para que seja identificado o edital da oportunidade, inclusive tratando particularidades da Mapfre;
- Por fim, há o job para anexar o arquivo identificado anteriormente à Mapfre.

## Commands auxiliares
Além dos commands principais para a aplicação, foram adicionados alguns commands que auxiliam em outros processos:
- Command de backup - auto-explicativo;
- Command de geração de tokens do recaptcha, que como a aplicação antiga, gera tokens e grava-os no banco de dados para utilização no login e anexo de edital.
- Command de gerenciamento de proxies, que grava, remove, altera ou restaura um proxy. Os proxies são necessários na aplicação pois a Mapfre bloqueia tentativas de anexar edital feitas em menos de 2 minutos para um IP;
- Command para remover cookies - auto-explicativo;

**Os commands descritos nos passos acima, foram definidos utilizando o mecanismo de Task Scheduling do Laravel, para que possam funcionar, devem seguir a documentação. Ex.:**
```
* * * * * php /sade-cn-rl-seguro/artisan schedule:run >> /dev/null 2>&1
```
_Obs: olhar no arquivo mostrado na documentação para entender os horários que os commands funcionam._

## TODO
- Definir no supervisor, workers para a aplicação;