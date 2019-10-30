<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use DB;

use App\Http\Requests\Contato\StoreRequest;
use App\Http\Requests\Contato\UpdateRequest;

use App\Models\Contato;
use App\Models\Mensagem;

class ContatoController extends Controller
{
    /**
     * Exibe todos os contatos existentes.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $contatos = Contato::all();

        return response()->json(compact('contatos'));
    }

    /**
     * Registra novo contato.
     *
     * @param  StoreRequest  $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        $contato = DB::transaction(function() use ($request) {

            return Contato::create($request->all());

        });

        return response()->json(compact('contato'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Contato $contato
     *
     * @return JsonResponse
     */
    public function show(Contato $contato) : JsonResponse
    {
        $contato->mensagens;
        return response()->json(compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Contato $contato)
    {
        $contato = DB::transaction(function() use ($request, $contato) {

            $contato->update($request->all());
            return $contato;

        });

        return response()->json(compact('contato'), 200);
    }

    /**
     * Remove contato especificado.
     *
     * @param  Contato  $contato
     *
     * @return JsonResponse
     */
    public function destroy(Contato $contato) : JsonResponse
    {
        DB::transaction(function() use ($contato) {

            Mensagem::where('contato_id', $contato->id)->delete();
            $contato->delete();

        });

        return response()->json([], 204);
    }
}
