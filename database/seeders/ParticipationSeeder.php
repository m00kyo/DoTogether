<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipationSeeder extends Seeder
{
    public function run(): void
    {
        $ania  = User::where('email', 'ania@example.pl')->first();
        $marek = User::where('email', 'marek@example.pl')->first();
        $zofia = User::where('email', 'zofia@example.pl')->first();
        $tomek = User::where('email', 'tomek@example.pl')->first();

        $bieg      = Activity::where('title', 'Poranny bieg w parku Łazienkowskim')->first();
        $sushi     = Activity::where('title', 'Warsztaty gotowania sushi')->first();
        $teatr     = Activity::where('title', 'Wyjście do Teatru Narodowego')->first();
        $wycieczka = Activity::where('title', 'Wycieczka do Kampinoskiego Parku Narodowego')->first();
        $malarstwo = Activity::where('title', 'Wieczór z malowaniem akwarelami')->first();
        $gra       = Activity::where('title', 'Miejska gra terenowa — odkryj Pragę!')->first();

        $participations = [
            // marek dołącza do biegu
            ['user_id' => $marek->id, 'activity_id' => $bieg->id,      'status' => 'CONFIRMED'],
            // tomek dołącza do biegu
            ['user_id' => $tomek->id, 'activity_id' => $bieg->id,      'status' => 'CONFIRMED'],
            // ania dołącza do sushi (marek jest twórcą)
            ['user_id' => $ania->id,  'activity_id' => $sushi->id,     'status' => 'CONFIRMED'],
            // zofia dołącza do sushi
            ['user_id' => $zofia->id, 'activity_id' => $sushi->id,     'status' => 'CONFIRMED'],
            // tomek dołącza do sushi, ale potem anuluje
            ['user_id' => $tomek->id, 'activity_id' => $sushi->id,     'status' => 'CANCELLED', 'cancel_reason' => 'Zmiana planów.', 'cancelled_at' => now()],
            // ania dołącza do teatru
            ['user_id' => $ania->id,  'activity_id' => $teatr->id,     'status' => 'CONFIRMED'],
            // marek dołącza do teatru
            ['user_id' => $marek->id, 'activity_id' => $teatr->id,     'status' => 'CONFIRMED'],
            // ania dołącza do wycieczki
            ['user_id' => $ania->id,  'activity_id' => $wycieczka->id, 'status' => 'CONFIRMED'],
            // zofia dołącza do wycieczki
            ['user_id' => $zofia->id, 'activity_id' => $wycieczka->id, 'status' => 'CONFIRMED'],
            // marek dołącza do malarstwa
            ['user_id' => $marek->id, 'activity_id' => $malarstwo->id, 'status' => 'CONFIRMED'],
            // tomek dołącza do malarstwa
            ['user_id' => $tomek->id, 'activity_id' => $malarstwo->id, 'status' => 'CONFIRMED'],
            // ania dołącza do gry terenowej
            ['user_id' => $ania->id,  'activity_id' => $gra->id,       'status' => 'CONFIRMED'],
            // zofia dołącza do gry terenowej
            ['user_id' => $zofia->id, 'activity_id' => $gra->id,       'status' => 'CONFIRMED'],
            // tomek dołącza do gry
            ['user_id' => $tomek->id, 'activity_id' => $gra->id,       'status' => 'CONFIRMED'],
        ];

        foreach ($participations as $data) {
            Participation::firstOrCreate(
                ['user_id' => $data['user_id'], 'activity_id' => $data['activity_id']],
                $data
            );
        }
    }
}
