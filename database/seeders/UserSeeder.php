<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Pasha',
            'phone' => '09362267050',
            'email' => 'a.pasha.aameri@gmail.com',
            'bio' => 'some bio information and text here.'
        ])->assignRole(WRITER_ROLE);
    }
}
