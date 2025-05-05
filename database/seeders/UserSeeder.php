<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operatorUser = User::factory()->create([
            'name'     => 'Super Admin',
            'email'    => 'operator@example.com',
            'password' => Hash::make('password'),
            'nip'      => '1234567',
        ]);

        $kaprodUser = User::factory()->create([
            'name'     => 'Kaprod User',
            'email'    => 'kaprod@example.com',
            'password' => Hash::make('password'),
            'nip'      => '7654321',
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);

        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        $operatorUser->assignRole($superAdminRole);

        $kaprodRole = Role::firstOrCreate(['name' => 'kaprod', 'guard_name' => 'web']);

        $kaprodPermissions = [
            'view_pengajuan',
            'view_any_pengajuan',
            'create_pengajuan',
            'update_pengajuan',

            'view_pengajuan::final',
            'view_any_pengajuan::final',
            'create_pengajuan::final',
            'update_pengajuan::final',

            'widget_StatusPengajuanFinalOverview',
            'widget_StatusPengajuanOverview',
        ];

        $permissions = Permission::whereIn('name', $kaprodPermissions)->get();

        $kaprodRole->syncPermissions($permissions);

        $kaprodUser->assignRole($kaprodRole);
    }
}
