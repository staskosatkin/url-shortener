<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUrl extends FormRequest
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
            'hash' => 'required|min:16|max:16',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all();
        $data['api_dev_key'] = $this->query('api_dev_key');
        $data['hash'] = $this->route('hash');
        return $data;
    }

    public function getHash()
    {
        return $this->route('hash');
    }

    public function getApiDevKey()
    {
        return $this->query('api_dev_key');
    }
}
