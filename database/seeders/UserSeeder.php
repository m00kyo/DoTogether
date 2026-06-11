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
            [
                'nickname'      => 'kasia_m',
                'email'         => 'kasia@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1997-04-12',
                'bio'           => 'Fotografka i miłośniczka podróży.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'piotr_n',
                'email'         => 'piotr@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1991-09-03',
                'bio'           => 'Fan siatkówki i muzyki jazzowej.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'bartek_s',
                'email'         => 'bartek@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1999-12-20',
                'bio'           => 'Programista hobbystycznie zajmujący się grafiką 3D.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'marta_j',
                'email'         => 'marta@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '2001-02-28',
                'bio'           => 'Studentka architektury, uwielbiam spacery po mieście.',
                'role'          => 'USER',
            ],
            [
                'nickname'      => 'lukasz_b',
                'email'         => 'lukasz@example.pl',
                'password_hash' => Hash::make('password'),
                'date_of_birth' => '1985-08-17',
                'bio'           => 'Maratończyk i kucharz amator.',
                'role'          => 'USER',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['email' => $user['email']], $user);
        }
    }
}
