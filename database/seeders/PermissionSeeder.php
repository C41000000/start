<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Definimos as permissões no novo padrão: recurso.acao
        $permissions = [
            'product.create',
            'product.view',
            'product.update',
            'product.delete',
            'category.create',
            'category.view',
            'category.update',
            'category.delete',
        ];

        // 2. Criamos as permissões (usando firstOrCreate para evitar erros em re-execuções)
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api',
            ]);
        }

        // 3. Criamos ou recuperamos o Role Admin
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'api',
        ]);

        // 4. Sincronizamos todas as permissões com esse Role
        // O syncPermissions é melhor que givePermissionTo em Seeders porque não duplica
        $role->syncPermissions(Permission::all());

        // 5. Atribuímos ao seu usuário
        $user = User::where('email', 'caioamorim732@gmail.com')->first();

        if ($user) {
            $user->assignRole($role);
        }
    }
}
