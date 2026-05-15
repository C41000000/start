<?php

declare(strict_types=1);

namespace App\Http\Requests\Catalog\Products;

use Illuminate\Foundation\Http\FormRequest;

class ListProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // A autorização via Policy já está sendo feita no Controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],

            'sort_by' => ['nullable', 'string', 'in:name,price,stock_quantity,created_at'],
            'sort_order' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    /**
     * Customizacao das mensagens de erro (Opcional)
     */
    public function messages(): array
    {
        return [
            'category_id.exists' => 'A categoria selecionada é inválida.',
            'per_page.max' => 'Você não pode listar mais de 100 produtos por vez.',
        ];
    }

    /**
     * Prepara os dados para validação.
     * Útil para garantir que per_page e page sejam inteiros.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'per_page' => $this->integer('per_page', 15),
            'page' => $this->integer('page', 1),
            'sort_by' => $this->input('sort_by', 'name'), // Default por nome
            'sort_order' => $this->input('sort_order', 'asc'),
        ]);
    }
}
