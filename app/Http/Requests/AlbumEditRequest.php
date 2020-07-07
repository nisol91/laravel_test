<?php

namespace App\Http\Requests;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;


// per la validazione posso creare un middleware che mi controlli che la richiesta sia ben fatta
class AlbumEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::find($this->id);
        if (\Gate::denies('manage-album', $album)) {
            return false;
        }
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
