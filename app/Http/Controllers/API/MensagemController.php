<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use DB;

use App\Http\Requests\Mensagem\StoreRequest;
use App\Http\Requests\Mensagem\UpdateRequest;

use App\Http\Resources\Mensagem\MensagemResource;

use App\Models\Mensagem;

class MensagemController extends Controller
{
    /**
     * Salva nova mensagem.
     *
     * @param  StoreRequest  $request
     *
     * @return MensagemResource
     */
    public function store(StoreRequest $request) : MensagemResource
    {
        $mensagem = DB::transaction(function() use ($request) {

            return Mensagem::create($request->all());

        });

        return new MensagemResource($mensagem);
    }

    /**
     * Atualiza mensagem.
     *
     * @param  UpdateRequest  $request
     * @param  Mensagem $mensagem
     *
     * @return MensagemResource
     */
    public function update(UpdateRequest $request, Mensagem $mensagem) : MensagemResource
    {
        $mensagem = DB::transaction(function() use ($request, $mensagem) {

            $mensagem->update($request->all());
            return $mensagem;

        });

        return new MensagemResource($mensagem);
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
