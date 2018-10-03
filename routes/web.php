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

Route::get('/', 'HomeController@index')->middleware('auth');

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::put('/senha/redefine', 'UserController@redefine')->middleware('auth');

Route::post('/cn/reserva/create', 'ReservaCNController@create')->middleware('auth');

Route::delete('/cn/reserva/delete', 'ReservaCNController@delete')->middleware('auth');

Route::post('/io/reserva/create', 'ReservaIOController@create')->middleware('auth');

Route::delete('/io/reserva/delete', 'ReservaIOController@delete')->middleware('auth');

Route::get('/download/bb/{licitacao_bb}', 'AbstractLicitacaoController@download')->middleware('auth')->name('download-bb');

Route::get('/download/cn/{licitacao_cn}', 'AbstractLicitacaoController@download')->middleware('auth')->name('download-cn');

Route::post('/oportunidade', 'LicitacaoBBController@create')->middleware('auth.basic'); //requisicao direta do carga, requer autenticacao basic (olhar documentação do Laravel)
