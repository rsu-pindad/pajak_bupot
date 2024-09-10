<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions pajak
        Permission::create(['name' => 'view bukti_potong']);
        Permission::create(['name' => 'edit bukti_potong']);
        Permission::create(['name' => 'create bukti_potong']);
        Permission::create(['name' => 'delete bukti_potong']);
        Permission::create(['name' => 'publish bukti_potong']);
        Permission::create(['name' => 'upload bukti_potong']);

        Permission::create(['name' => 'view personalia']);
        Permission::create(['name' => 'edit personalia']);
        Permission::create(['name' => 'create personalia']);
        Permission::create(['name' => 'delete personalia']);
        Permission::create(['name' => 'publish personalia']);
        Permission::create(['name' => 'upload personalia']);

        Permission::create(['name' => 'view payroll_insentif']);
        Permission::create(['name' => 'edit payroll_insentif']);
        Permission::create(['name' => 'create payroll_insentif']);
        Permission::create(['name' => 'delete payroll_insentif']);
        Permission::create(['name' => 'publish payroll_insentif']);
        Permission::create(['name' => 'upload payroll_insentif']);
        // Permission::create(['name' => 'pdf payroll_insentif']);

        Permission::create(['name' => 'view payroll_kehadiran']);
        Permission::create(['name' => 'edit payroll_kehadiran']);
        Permission::create(['name' => 'create payroll_kehadiran']);
        Permission::create(['name' => 'delete payroll_kehadiran']);
        Permission::create(['name' => 'publish payroll_kehadiran']);
        // Permission::create(['name' => 'pdf payroll_kehadiran']);

        // create roles and assign created permissions
        $pass = config('app.seeder_default');

        $role1 = Role::create(['name' => 'pajak']);
        $role1->givePermissionTo(['view bukti_potong', 'edit bukti_potong', 'create bukti_potong', 'delete bukti_potong', 'publish bukti_potong']);

        $role2 = Role::create(['name' => 'personalia']);
        $role2->givePermissionTo(['view personalia', 'edit personalia', 'create personalia', 'delete personalia', 'publish personalia', 'upload personalia']);

        // or may be done by chaining
        $role3 = Role::create(['name' => 'payroll'])
                     ->givePermissionTo(['view payroll_insentif', 'edit payroll_insentif', 'create payroll_insentif', 'delete payroll_insentif', 'publish payroll_insentif', 'upload payroll_insentif', 'view payroll_kehadiran', 'edit payroll_kehadiran', 'create payroll_kehadiran', 'delete payroll_kehadiran', 'publish payroll_kehadiran']);

        $role4 = Role::create(['name' => 'super-admin']);
        $role4->givePermissionTo(Permission::all());

        $user4 = User::create([
            'npp'               => 'it',
            'email'             => 'it@pindadmedika.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($pass),  // password
            'remember_token'    => Str::random(10),
        ]);
        $user4->assignRole($role4);

        $user1 = User::create([
            'npp'               => 'pajak',
            'email'             => 'pajak@pindadmedika.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($pass),  // password
            'remember_token'    => Str::random(10),
        ]);
        $user1->assignRole($role1);

        $user2 = User::create([
            'npp'               => 'personalia',
            'email'             => 'personalia@pindadmedika.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($pass),  // password
            'remember_token'    => Str::random(10),
        ]);
        $user2->assignRole($role2);
        $user3 = User::create([
            'npp'               => 'payroll',
            'email'             => 'payroll@pindadmedika.com',
            'email_verified_at' => now(),
            'password'          => Hash::make($pass),  // password
            'remember_token'    => Str::random(10),
        ]);
        $user3->assignRole($role3);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
