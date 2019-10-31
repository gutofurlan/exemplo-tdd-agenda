<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\Contato\ContatoResource;
use App\Http\Resources\Contato\ContatoCollectionResource;

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
     * @return ContatoCollectionResource
     */
    public function index() : ContatoCollectionResource
    {
        $contatos = Contato::all();

        return new ContatoCollectionResource($contatos);
    }

    /**
     * Registra novo contato.
     *
     * @param  StoreRequest  $request
     *
     * @return ContatoResource
     */
    public function store(StoreRequest $request) : ContatoResource
    {
        $contato = DB::transaction(function() use ($request) {

            return Contato::create($request->all());

        });

        return new ContatoResource($contato);
    }

    /**
     * Exibe contato com mensagens do mesmo.
     *
     * @param  Contato $contato
     *
     * @return ContatoResource
     */
    public function show(Contato $contato) : ContatoResource
    {
        $contato->mensagens;

        return new ContatoResource($contato);
    }

    /**
     * Atualiza contato.
     *
     * @param  UpdateRequest $request
     * @param  Contato $contato
     *
     * @return ContatoResource
     */
    public function update(UpdateRequest $request, Contato $contato) : ContatoResource
    {
        $contato = DB::transaction(function() use ($request, $contato) {

            $contato->update($request->all());
            return $contato;

        });

        return new ContatoResource($contato);
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
