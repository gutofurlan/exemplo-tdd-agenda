<?php

Route::namespace('API')->middleware('bindings')->group(function () {

    Route::apiResource('contato', 'ContatoController');

});
