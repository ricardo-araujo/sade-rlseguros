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

Route::post('/oportunidade', 'LicitacaoBBController@create')->middleware('auth.basic'); //requisicao direta do carga, requer autenticacao basic (olhar documentação do Laravel)

Route::middleware('auth')->group(function() {

    Route::get('/', 'HomeController@index');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::put('/senha/redefine', 'UserController@redefine');

    Route::post('/cn/reserva/create', 'ReservaCNController@create');

    Route::delete('/cn/reserva/delete', 'ReservaCNController@delete');

    Route::post('/io/reserva/create', 'ReservaIOController@create');

    Route::delete('/io/reserva/delete', 'ReservaIOController@delete');

    Route::get('/bb/{licitacao_bb}/download', 'AbstractLicitacaoController@download')->name('download-bb');

    Route::get('/cn/{licitacao_cn}/download', 'AbstractLicitacaoController@download')->name('download-cn');

    Route::get('/orgao', 'OrgaoMapfreController@show');

    Route::put('/orgao', 'OrgaoMapfreController@update');
});
