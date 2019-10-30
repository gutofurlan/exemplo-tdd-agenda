<?php

namespace App\Http\Requests\Contato;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StoreRequest extends FormRequest
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
            'nome'            => ['required', 'string', 'min:3', 'max:60'],
            'sobrenome'       => ['required', 'string', 'min:3', 'max:60'],
            'email'           => ['required', 'email', 'min:6', 'max:60', "unique:contatos,email"],
            'telefone'        => ['required', 'string', 'min:9', 'max:20'],
        ];

        return $rules;
    }

    /**
     * Sobrescrita do método de validação
     *
     * @return void
     */
    public function validateResolved()
    {
        parent::validateResolved();

        $this->inputs['telefone'] = preg_replace("/\D/", "", $this->inputs['telefone']);

        $this->replace($this->inputs);
    }

    public function messages()
    {
        return [];
    }
}
