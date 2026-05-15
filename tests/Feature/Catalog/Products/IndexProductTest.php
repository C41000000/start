<?php

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\User;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    // Limpa o cache para evitar conflitos de permissão entre testes
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    Permission::findOrCreate('product.view', 'api');
});

test('it should list products with pagination and correct json structure', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.view');

    // Cria 15 produtos para garantir que a paginação apareça
    Product::factory()->count(15)->create();

    // Act
    $response = $this->actingAs($user, 'api')
        ->getJson(route('products.index', ['per_page' => 10]));

    // Assert
    $response->assertOk()
        ->assertJsonCount(10, 'data') // Verifica se respeitou o per_page
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'uuid', 'name', 'price', 'category' => ['id', 'name']
                ]
            ],
            'meta' => ['current_page', 'last_page', 'total'],
            'links' => ['first', 'last', 'prev', 'next']
        ]);
});

test('it should filter products by name in the index route', function () {
    $user = User::factory()->create();
    $user->givePermissionTo('product.view');

    Product::factory()->create(['name' => 'Specific Pizza']);
    Product::factory()->create(['name' => 'General Burger']);

    $response = $this->actingAs($user, 'api')
        ->getJson(route('products.index', ['search' => 'pizza']));

    // Assert
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        // O Ponto crucial é o "data.0.name"
        ->assertJsonPath('data.0.name', 'Specific Pizza');
});

test('it should return products ordered by price descending', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.view');

    Product::factory()->create(['name' => 'Cheap', 'price' => 10]);
    Product::factory()->create(['name' => 'Expensive', 'price' => 100]);

    // Act
    $response = $this->actingAs($user, 'api')
        ->getJson(route('products.index', [
            'sort_by' => 'price',
            'sort_order' => 'desc'
        ]));

    // Assert
    $response->assertOk()
        ->assertJsonPath('data.0.name', 'Expensive')
        ->assertJsonPath('data.1.name', 'Cheap');
});

test('it should not allow guest users to list products', function () {
    // Act
    $response = $this->getJson(route('products.index'));

    // Assert
    $response->assertUnauthorized(); // 401
});
