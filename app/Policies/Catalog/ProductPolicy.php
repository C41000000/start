<?php

declare(strict_types=1);

namespace App\Policies\Catalog;

use App\Models\Catalog\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * O "Super-Poder": Se for admin, ignora as checagens abaixo e libera tudo.
     */
    //    public function before(User $user, string $ability): ?bool
    //    {
    //        if ($user->hasRole('admin')) {
    //            return true;
    //        }
    //
    //        return null; // Continua para os métodos abaixo se não for admin
    //    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('product.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('product.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('product.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('product.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('product.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('product.update');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->hasPermissionTo('product.delete');
    }
}
