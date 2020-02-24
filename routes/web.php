<?php


/* Nombre de la ruta ||| y en donde van estar esas rutas=>app/http/controllers/book*/
Route::get('/', 'Auth\LoginController@validacionLogin');

Route::resource('cargaempleado', 'PestanaController');

//Agrega un nuevo documento
Route::post('nuevoDocumento/', 'PestanaController@nuevoDocumento')->name('doc.create');
//Abre el documento(pdf) del empleado selecionado
Route::get('verDocumento/{ruta}/', 'PestanaController@verDocumento')->name('ver.doc');

Route::post('/login', 'auth\LoginController@login')->name('login');
Route::post('logout', 'auth\LoginController@logout')->name('logout');
