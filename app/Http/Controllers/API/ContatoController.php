<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use DB;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return response()->json(compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
