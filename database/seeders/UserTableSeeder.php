<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $users = [
            [
                'id' => 1,
                'name' => 'Max Mustermann',
                'email' => 'example@email.de',
                'email_verified_at' => $dateNow,
                'password' => Hash::make('password'),
                'remember_token' => null,
            ],
        ];

        foreach ($users as $user) {
            if (! User::where('email', '=', $user['email'])->orWhere('id', '=', $user['id'])->first()) {
                $newUser = User::create($user);
                echo 'User: '.$user['name']."\n";
                echo 'ApiToken: '.$newUser->createToken('ApiToken')->plainTextToken."\n";
            }
        }
    }
}
