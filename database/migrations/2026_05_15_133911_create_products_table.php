<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Catalog\Category; // Importando do novo local!

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignIdFor(Category::class)->constrained()->restrictOnDelete();
            $table->string('name')->comment('Nome de exibição no PDV e Cardápio');
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2)->comment('Preço final de venda');
            $table->string('image_url')->nullable();
            $table->boolean('manage_stock')->default(false)
                ->comment('Flag que define se o produto controla estoque físico direto');
            $table->decimal('stock_quantity', 10, 3)->default(0)
                ->comment('Saldo atual em estoque (suporta 3 casas decimais para pesos)');
            $table->boolean('is_active')->default(true)
                ->comment('Inativa o produto sem precisar apagar do banco');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
