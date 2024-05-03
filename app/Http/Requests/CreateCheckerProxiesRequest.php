<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCheckerProxiesRequest extends FormRequest
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
        return [
            'proxies' => ['required', 'array'],
            'proxies.*' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $proxies = array_filter(preg_split('/\r\n|\r|\n/', $this->proxies));
        $this->merge([
            'proxies' => $proxies
        ]);
    }
}
