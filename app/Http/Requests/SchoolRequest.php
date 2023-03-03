<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'name'          => 'required|string|min:5|max:150',
            'address'       => 'required|string|min:5|max:250',
            'description'   => 'string|nullable',
            'contacts'      => 'array|nullable',
            'ticket_amount' => 'integer|nullable:min:0'
        ];
    }

    public function messages()
    {
        return [
            'name.min'          => 'Минимальная длина названия клуба 5 символов',
            'name.max'          => 'Максимальная длина названия клуба 150 символов',
            'name.required'     => 'Это поле обязательно для заполнения',
            'address.min'       => 'Минимальная длина адреса клуба 5 символов',
            'address.max'       => 'Максимальная длина адреса клуба 250 символов',
            'address.required'  => 'Это поле обязательно для заполнения',
            'ticket_amount'     => 'Стоимость абонемента не может быть меньше нуля'
        ];
    }
}
