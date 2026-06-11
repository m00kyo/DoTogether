<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserReport;
use Illuminate\Database\Seeder;

class UserReportSeeder extends Seeder
{
    public function run(): void
    {
        $ania = User::where('email', 'ania@example.pl')->first();
        $marek = User::where('email', 'marek@example.pl')->first();
        $tomek = User::where('email', 'tomek@example.pl')->first();

        $reports = [
            [
                'reporter_id' => $ania->id,
                'reported_id' => $tomek->id,
                'reason' => 'Użytkownik zachowuje się nieodpowiednio na wydarzeniach.',
            ],
            [
                'reporter_id' => $marek->id,
                'reported_id' => $tomek->id,
                'reason' => 'Podejrzane aktywność konta.',
            ],
        ];

        foreach ($reports as $data) {
            UserReport::firstOrCreate(
                ['reporter_id' => $data['reporter_id'], 'reported_id' => $data['reported_id']],
                $data
            );
        }
    }
}
