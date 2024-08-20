<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssignPermissionsToRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::findByName(WRITER_ROLE)->givePermissionTo([
            Permission::findByName('create posts', 'api'),
            Permission::findByName('update posts', 'api'),
            Permission::findByName('delete posts', 'api'),
        ]);
    }
}
