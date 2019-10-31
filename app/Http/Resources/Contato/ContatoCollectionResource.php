<?php

namespace App\Http\Resources\Contato;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ContatoCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => ContatoResource::collection($this->collection)
        ];
    }
}
