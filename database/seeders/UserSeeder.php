<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * php artisan db:seed --class=RolePermissionSeeder
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);

        $user = User::updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'first_name' => 'system',
            'last_name' => 'admin',
            'phone' => '+85512345678',
            'password' => Hash::make('12345678'),
            'status' => 'active',
        ]);

        $user->roles()->syncWithoutDetaching([1]);
    }
}
