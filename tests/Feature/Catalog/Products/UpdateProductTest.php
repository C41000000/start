<?php

declare(strict_types=1);

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function () {
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    Permission::findOrCreate('product.update', 'api');
});

test('it should update a product successfully via uuid route', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.update');

    $category = Category::factory()->create();
    $newCategory = Category::factory()->create();

    $product = Product::factory()->create([
        'category_id' => $category->id,
        'name' => 'Pizza Antiga',
    ]);

    $payload = [
        'category_id' => $newCategory->uuid,
        'name' => 'Pizza de Calabresa Turbinada',
        'description' => 'Agora com borda recheada',
        'price' => 59.90,
        'manage_stock' => true,
        'stock_quantity' => 20,
        'is_active' => true,
    ];

    // Act & Assert
    $this->actingAs($user, 'api')
        ->putJson(route('products.update', ['uuid' => $product->uuid]), $payload)
        ->assertOk()
        ->assertJsonPath('name', 'Pizza de Calabresa Turbinada');

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Pizza de Calabresa Turbinada',
        'category_id' => $newCategory->id,
    ]);
});

test('it should return 403 when user has no permission to update', function () {
    // Arrange
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $category = Category::factory()->create();
    // Act & Assert
    $this->actingAs($user, 'api')
        ->putJson(route('products.update', $product->uuid), [
            'name' => 'Attempting update',
            'category_id' => $category->uuid,
            'price' => 59.90,
        ])
        ->assertForbidden();
});

test('it should return 404 when product uuid does not exist', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.update');
    $fakeUuid = (string) Str::uuid();
    $category = Category::factory()->create(); // Criamos uma categoria válida
    $fakeUuid = (string) Str::uuid();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->putJson(route('products.update', $fakeUuid), [
            'name' => 'Update non-existent',
            'price' => 10.00,
            'category_id' => $category->uuid,
        ])
        ->assertNotFound();
});

test('it should validate required fields in update route', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.update');
    $product = Product::factory()->create();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->putJson(route('products.update', $product->uuid), [])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'price', 'category_id']);
});
