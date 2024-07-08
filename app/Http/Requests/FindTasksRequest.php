<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class FindTasksRequest extends FormRequest
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
            'due_date' => 'date',
            'status_id' => 'integer|exists:statuses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'date' => 'Поле :attribute должно быть датой',
            'integer' => 'Поле :attribute должно быть целым числом',
            'exists' => 'Поле :attribute не найдено в справочнике',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(
            new JsonResponse([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400));
    }
}
