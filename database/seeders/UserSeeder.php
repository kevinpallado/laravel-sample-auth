<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// models
use App\Models\User;
use App\Models\UserInformation;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Admin Admin',
                'email' => 'gaba2kalang@gmail.com',
                'password' => bcrypt('admin'),
                'additionalInformation' => [
                    'first_name' => 'Ace',
                    'middle_name' => 'Dragon',
                    'last_name' => 'Admin',
                    'street_address' => 'East Blue',
                    'postal_code' => 234234324
                ]
            ]
        ];

        foreach($data as $user) {
            $userAccount = User::updateOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'email' => $user['email'], 'password' => $user['password']]
            );
            UserInformation::updateOrCreate(
                ['users_id' => $userAccount->id],
                array_merge($user['additionalInformation'],['users_id' => $userAccount->id])
            );
        }
    }
}
