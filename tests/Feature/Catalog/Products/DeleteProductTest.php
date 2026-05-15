<?php

declare(strict_types=1);

use App\Models\Catalog\Product;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function () {
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    Permission::findOrCreate('product.delete', 'api');
});

test('it should delete a product successfully and return 204', function () {

    $user = User::factory()->create();
    $user->givePermissionTo('product.delete');

    $product = Product::factory()->create();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->deleteJson(route('products.destroy', $product->uuid))
        ->assertNoContent(); // Verifica especificamente o status 204

    // Verifica se saiu do banco (ou se foi marcado como excluído se usar SoftDelete)
    $this->assertDatabaseMissing('products', [
        'id' => $product->id,
        'deleted_at' => null
    ]);
});

test('it should not allow to delete a product without product.delete permission', function () {
    // Arrange
    $user = User::factory()->create();
    $product = Product::factory()->create();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->deleteJson(route('products.destroy', $product->uuid))
        ->assertForbidden(); // Status 403
});

test('it should return 404 when trying to delete a non-existent product', function () {
    // Arrange
    $user = User::factory()->create();
    $user->givePermissionTo('product.delete');
    $fakeUuid = (string) Str::uuid();

    // Act & Assert
    $this->actingAs($user, 'api')
        ->deleteJson(route('products.destroy', $fakeUuid))
        ->assertNotFound(); // Status 404
});
