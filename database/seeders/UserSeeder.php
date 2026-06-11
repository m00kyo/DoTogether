<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'nickname'      => 'admin',
                'email'         => 'admin@dotogether.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1990-01-01',
                'bio'           => 'Administrator serwisu DoTogether.',
                'role'          => 'ADMIN',
            ],
            [
                'nickname'      => 'ania_k',
                'email'         => 'ania@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1995-03-15',
                'bio'           => 'Uwielbiam sport i górskie wędrówki!',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'marek_w',
                'email'         => 'marek@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1988-07-22',
                'bio'           => 'Pasjonat gier planszowych i kulinariów.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'zofia_p',
                'email'         => 'zofia@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '2000-11-05',
                'bio'           => 'Lubię teatr, kino i sztukę współczesną.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'tomek_r',
                'email'         => 'tomek@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1993-06-30',
                'bio'           => null,
                'role'          => 'USER',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
