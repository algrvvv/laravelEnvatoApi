<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // обработка двух методов PUT / PATH
        // их отличия в том, что метод PUT перезапишет весь объект, пример:
        // {"id": 1, "name": "Mazda", "year": "01.01.2001"} -> PUT: {"year": "02.02.2010"} ==> {"id": 1, "year": "02.02.2010"}
        // Метод PUT полностью перезаписал этот объект. А метод PATH просто изменит нужное значение по нунжому ключу
        // {"id": 1, "name": "Mazda", "year": "01.01.2001"} -> PATH:{"year": "02.02.2010"} ==> {"id": 1, "name": "Mazda","year": "02.02.2010"}

        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'name'       => ['required'],
                'type'       => ['required', Rule::in(['I', 'B', 'i', 'b'])],
                'email'      => ['required', 'email'],
                'address'    => ['required'],
                'city'       => ['required'],
                'state'      => ['required'],
                'postalCode' => ['required'],
            ];
        } else {
            return [
                'name'       => ['sometimes', 'required'],
                'type'       => ['sometimes', 'required', Rule::in(['I', 'B', 'i', 'b'])],
                'email'      => ['sometimes', 'required', 'email'],
                'address'    => ['sometimes', 'required'],
                'city'       => ['sometimes', 'required'],
                'state'      => ['sometimes', 'required'],
                'postalCode' => ['sometimes', 'required'],
            ];
        }
    }


    protected function prepareForValidation()
    {
        if($this->postalCode){
            $this->merge([
                'postal_code' => $this->postalCode
            ]);
        } 
    }
}
