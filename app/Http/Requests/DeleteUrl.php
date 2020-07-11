<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class DeleteUrl extends FormRequest
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
        return [
            'api_dev_key' => 'required|min:20|max:20',
            'hash' => 'required|min:7|max:16',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param  array|mixed|null  $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all();
        $data['api_dev_key'] = $this->query('api_dev_key');
        $data['hash'] = $this->route('hash');
        return $data;
    }

    public function getApiDevKey()
    {
        return $this->get('api_dev_key');
    }

    public function getHash()
    {
        return $this->route('hash');
    }
}
