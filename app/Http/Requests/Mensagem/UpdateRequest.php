<?php

namespace App\Http\Requests\Mensagem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateRequest extends FormRequest
{
    private $inputs;

    public function __construct(Request $request)
    {
        $this->inputs = $request->all();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id'            => ['required', 'integer', 'between:1,2147483647', "exists:mensagems,id"],
            'contato_id'    => ['required', 'integer', 'between:1,2147483647', "exists:contatos,id"],
            'mensagem'      => ['required', 'string', 'min:1'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [];
    }
}
