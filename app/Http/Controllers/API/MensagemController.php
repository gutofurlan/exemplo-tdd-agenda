<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use DB;

use App\Http\Requests\Mensagem\StoreRequest;
use App\Http\Requests\Mensagem\UpdateRequest;

use App\Models\Mensagem;

class MensagemController extends Controller
{
    /**
     * Salva nova mensagem.
     *
     * @param  StoreRequest  $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request) : JsonResponse
    {
        $mensagem = DB::transaction(function() use ($request) {

            return Mensagem::create($request->all());

        });

        return response()->json(compact('mensagem'), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Mensagem $mensagem)
    {
        $mensagem = DB::transaction(function() use ($request, $mensagem) {

            $mensagem->update($request->all());
            return $mensagem;

        });

        return response()->json(compact('mensagem'), 200);
    }

    /**
     * Remove mensagem.
     *
     * @param  Mensagem  $mensagem
     * @return JsonResponse
     */
    public function destroy(Mensagem $mensagem) : JsonResponse
    {
        DB::transaction(function() use ($mensagem) {

            $mensagem->delete();

        });

        return response()->json([], 204);
    }
}
