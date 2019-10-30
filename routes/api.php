<?php

Route::namespace('API')->middleware('bindings')->group(function () {

    Route::apiResource('contato', 'ContatoController');

    Route::apiResource('mensagem', 'MensagemController')->only(['store', 'update', 'delete']);

});
