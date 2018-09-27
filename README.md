# Sistema Automatizado de Download de Editais
Projeto refatorado e baseado em Laravel, que visa identificar oportunidades e realizar download de editais dos portais [Banco do Brasil](https://www.licitacoes-e.com.br/), [Comprasnet](http://www.comprasnet.gov.br/) e [Imprensa Oficial](https://www.imprensaoficial.com.br/) e anexá-los no portal da [Mapfre](http://mapfrenegociospublicos.com.br)

## Instalação
Após preencher os arquivos de configuração (diretório config) e .env:
```
composer install
```
```
php artisan migrate
```
```
php artisan db:seed
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
Os crons definidos p/ captura de oportunidades (CN e IO) e o envio de oportunidades do BB são os gatilhos que iniciam os processos do SADE.
Assim que uma oportunidade é inserida no banco de dados, o sistema utiliza a funcionalidade de [Observers](https://laravel.com/docs/5.6/eloquent#observers), e no observer de criação de um model de licitacao é disparado um [Event](https://laravel.com/docs/5.6/events) de criação de licitação. Após disparado, existem os [Listeners](https://laravel.com/docs/5.6/events#defining-listeners) que 'escutam' o devido evento, e são esses listeners que dão início aos [Jobs](https://laravel.com/docs/5.6/queues) pertinentes a rotina de cada portal.
Os jobs podem ser compartilhados entre os processos dos três portais ou caso um portal tenha um processo diferente, o nome do job tem o sufico do portal ao qual ele pertence (Ex.: UploadEditalCNJob).
Os jobs dos portais BB e IO compartilham da mesma sequencia de uso, pois tem seu processo feito de forma automatizada, são eles:
_Após recebida uma oportunidade:_
- Faz o download dos arquivos em anexo;
- Processa os arquivos, descompactando e adequando seu nome p/ remover caracteres diferentes e identificando qual é o arquivo principal p/upload;
- Busca CNPJs nos arquivos, para criar as reservas dos possiveis órgãos;
- Identifica se os órgãos possuem código da Mapfre, caso não, tenta criá-los no portal e criam reservas p/ o órgao.

Tendo sido criada a reserva no job acima, é disparado o evento de criação de reserva, que segue a mesma lógica do passo anterior e também tem os mesmos jobs, que são:
- Validar a reserva na Mapfre (capturar viewstate e eventvalidation);
- Anexar edital na reserva criada.

O processo das oportunidades do CN é feito de forma diferente, pois não libera o edital no momento da captura da oportunidade:
Às 05h00 é iniciado o processo de captura de oportunidades do CN, e uma vez capturada, a oportunidade pode ter uma reserva criada manualmente pelo cliente do portal da Mapfre. Uma vez criada, a reserva possui dos Jobs que são encadeados no listener de reserva do CN, são eles:
- Validar a reserva, conforme BB e IO;
- Atribuição de um proxy logado a cada reserva;

Os jobs de licitação do CN são atrasados p/ iniciarem às 06h10 (horário observado como padrão de liberação dos editais das oportunidades) e são:
- Download dos anexos;
- Processamento dos arquivos;
- Upload de reservas p/ cada licitação.

_(Os jobs ja possuem seu arquivo de configuração na raiz do projeto que devem ser colocados p/ monitoria do supervisor p/ funcionamento das filas)_

## Commands auxiliares
Além dos commands principais para a aplicação, foram adicionados alguns commands que auxiliam em outros processos:
- Command de backup (auto-explicativo);
- Command de geração de tokens do recaptcha, que como a aplicação antiga, gera tokens e grava-os no banco de dados para utilização no login e anexo de edital.
- Command de gerenciamento de proxies, que grava, remove, altera ou restaura um proxy. Os proxies são necessários na aplicação pois a Mapfre bloqueia tentativas de anexar edital feitas em menos de 2 minutos para um IP;
- Command para enviar e-mail das oportunidades do dia;
- Command para truncar a tabela de jobs ao final do dia e remover jobs que não conseguiram ser processados;
- Command para login na Mapfre, com o objetivo de deixar os proxies disponveis com um cookie logado p/ cada, para realizar as tarefas na Mapfre (buscar/criar orgao e reserva, anexar edital);

**Os commands descritos nos passos acima, foram definidos utilizando o mecanismo de [Task Scheduling](https://laravel.com/docs/5.6/scheduling) do Laravel, para que possam funcionar, devem seguir a documentação. Ex.:**
```
No crontab:
* * * * * php /sade-cn-rl-seguro/artisan schedule:run >> /dev/null 2>&1
```

##TODO
Conforme SadeIO, criar alternativa p/ cadastro manual de reservas do cliente.
