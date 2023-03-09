<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        return [
            'title' => ['required', 'unique:posts', 'max:150'],
            'content' => ['nullable'],
            'type_id' => ['nullable', 'exists:types,id'],
            'technologies' => ['exists:technologies,id'],
            'cover_image' => ['nullable', 'image']
        ];
    }
        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Il titolo è richiesto',
            'title.unique' => ' E\' già presente un progetto con questo titolo',
            'title.max' => 'Il progetto non può essere lungo più di :max caratteri',
            'technologies.exists' => 'La tecnologia non è valida',
            'cover_image.image' => 'Inserire un formato di immagine valido',
            'cover_image.max' => 'Path dell\'immagine non valido'
        ];
    }
}
