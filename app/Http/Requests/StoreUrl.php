<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreUrl extends FormRequest
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
            'origin_url' => 'required|url',
            'custom_alias' => 'sometimes|min:1|max:10',
            'expire_date' => 'sometimes|date',
        ];
    }

    public function getApiDevKey(): string
    {
        return $this->get('api_dev_key');
    }

    public function getOriginUrl(): string
    {
        return $this->get('origin_url');
    }

    public function getCustomAlias(): ?string
    {
        return $this->get('custom_alias');
    }

    public function getExpireDate(): Carbon
    {
        return Carbon::make($this->get('expire_date'));
    }
}
