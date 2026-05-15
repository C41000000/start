<?php

namespace App\Http\Requests\Catalog\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer essa requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * As regras de validação aplicadas à requisição.
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'manage_stock' => ['boolean'],
            'is_active' => ['boolean'],
            'stock_quantity' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Opcional: Traduzindo os campos para as mensagens de erro automáticas ficarem bonitas
     * (útil caso você não tenha traduzido o arquivo pt-BR globalmente ainda).
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'categoria',
            'name' => 'nome',
            'description' => 'descrição',
            'price' => 'preço',
            'image_url' => 'imagem',
            'manage_stock' => 'controle de estoque',
            'stock_quantity' => 'quantidade em estoque',
            'is_active' => 'status ativo',
        ];
    }
}
