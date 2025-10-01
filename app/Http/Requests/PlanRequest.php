<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'          => ['required','string','max:190','unique:plans,name'],
            'price'         => ['required'],
            'currency'      => ['required','string','max:3'],
            'data_limit'    => ['required','integer'],
            'duration' => ['required','string','integer'],
            'image'         => ['required','image','mimes:png,jpg','max:1024'],
        ];

        if(request()->update_id){
            $rules['name'][3] = 'unique:plans,name,'.request()->update_id;
            $rules['image'][0] = 'nullable';
        }

        return $rules;
    }
}
