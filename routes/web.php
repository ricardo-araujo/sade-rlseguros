<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::put('/senha/redefine', 'UserController@redefine');

Route::post('/cn/reserva/create', 'ReservaCNController@create');

Route::delete('/cn/reserva/delete', 'ReservaCNController@delete');

Route::post('/io/reserva/create', 'ReservaIOController@create');

Route::delete('/io/reserva/delete', 'ReservaIOController@delete');

Route::get('/download/bb/{licitacao_bb}', 'AbstractLicitacaoController@download')->name('download-bb');

Route::get('/download/cn/{licitacao_cn}', 'AbstractLicitacaoController@download')->name('download-cn');

Route::post('/oportunidade', 'LicitacaoBBController@create'); //requisicao direta do carga, requer autenticacao basic (olhar documentação do Laravel)
