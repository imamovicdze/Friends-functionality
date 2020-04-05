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
     * @throws Exception
     */
    public function run()
    {
        $users = [
            [
                'name' => 'user1',
                'email' => 'user1@user.com',
                'password' => Hash::make('user1'),
                'api_token' => 'user1',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,

            ],
            [
                'name' => 'user2',
                'email' => 'user2@user.com',
                'password' => Hash::make('user2'),
                'api_token' => 'user2',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'user3',
                'email' => 'user3@user.com',
                'password' => Hash::make('user3'),
                'api_token' => 'user3',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'user4',
                'email' => 'user4@user.com',
                'password' => Hash::make('user4'),
                'api_token' => 'user4',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'name' => 'user5',
                'email' => 'user5@user.com',
                'password' => Hash::make('user5'),
                'api_token' => 'user5',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
