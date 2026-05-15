<?php

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    Permission::findOrCreate('product.create', 'api');
});

test('it should create a product successfully and generate uuid automatically', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.create');

    $category = Category::factory()->create();

    $payload = [
        'category_id' => $category->id,
        'name' => 'Pizza de Calabresa',
        'description' => 'Molho de tomate, mussarela e calabresa',
        'price' => 45.90,
        'manage_stock' => true,
        'stock_quantity' => 50,
    ];

    // Act & Assert
    $this->actingAs($user, 'api')
        ->postJson(route('products.store'), $payload)
        ->assertCreated()
        ->assertJsonPath('name', 'Pizza de Calabresa');

    $this->assertDatabaseHas('products', [
        'name' => 'Pizza de Calabresa',
        'category_id' => $category->id,
    ]);

    $product = Product::where('name', 'Pizza de Calabresa')->first();

    expect($product->uuid)->not->toBeNull()
        ->and($product->uuid)->toBeString()
        ->and(strlen($product->uuid))->toBe(36);
});

test('it should not allow to create a product without product.create permission', function () {
    // Arrange
    $user = User::factory()->create();
    $category = Category::factory()->create();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->postJson(route('products.store'), [
            'name' => 'Forbidden Product',
            'category_id' => $category->id,
            'price' => 10.00
        ])
        ->assertForbidden();
});

test('it should validate required fields when creating a product', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.create');

    // Act & Assert
    $this->actingAs($user, 'api')
        ->postJson(route('products.store'), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'price', 'category_id']);
});
