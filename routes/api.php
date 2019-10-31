<?php
Route::group(['middleware' => ['jwt.verify']], function() {
	Route::get('/funcionario', 'FuncionariosController@index');
	Route::get('/funcionario/{id}', 'FuncionariosController@getFuncionario');
	Route::post('/funcionario', 'FuncionariosController@cadastrarFuncionario');
	Route::put('/funcionario/{id}', 'FuncionariosController@atualizarFuncionario');
	Route::delete('/funcionario/{id}', 'FuncionariosController@removerFuncionario');
});

Route::post('/login', 'JwtAuthController@login');
Route::post('/logout', 'JwtAuthController@logout');
Route::post('/refresh', 'JwtAuthController@refresh');
