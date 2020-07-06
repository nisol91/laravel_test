<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


// per la validazione creo un middleware che mi controlli che la richiesta sia ben fatta
class AlbumCreationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // devono avere lo stesso nome che hanno nella request del form (name="")
        return [
            'name' => 'required|unique:albums,album_name',
            'description' => 'required',
            'album_thumb' => 'required|image',
            // 'user_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'serve il nome dell album!!!',
        ];
    }
}
