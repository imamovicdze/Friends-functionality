<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'user1',
                'email' => 'user1@user.com',
                'password' => Hash::make('user1')
            ],
            [
                'name' => 'user2',
                'email' => 'user2@user.com',
                'password' => Hash::make('user2')
            ],
            [
                'name' => 'user3',
                'email' => 'user3@user.com',
                'password' => Hash::make('user3')
            ],
            [
                'name' => 'user4',
                'email' => 'user4@user.com',
                'password' => Hash::make('user4')
            ],
            [
                'name' => 'user5',
                'email' => 'user5@user.com',
                'password' => Hash::make('user5')
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
