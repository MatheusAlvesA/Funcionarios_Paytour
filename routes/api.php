<?php

// Rotas principais
Route::group(['middleware' => ['jwt.verify']], function() {
	Route::get('/funcionario', 'FuncionariosController@index');
	Route::get('/funcionario/{id}', 'FuncionariosController@getFuncionario');
	Route::post('/funcionario', 'FuncionariosController@cadastrarFuncionario');
	Route::put('/funcionario/{id}', 'FuncionariosController@atualizarFuncionario');
	Route::delete('/funcionario/{id}', 'FuncionariosController@removerFuncionario');
});

// Rotas de login
Route::post('/login', 'JwtAuthController@login');
Route::get('/logout', 'JwtAuthController@logout');
Route::get('/refresh', 'JwtAuthController@refresh');
