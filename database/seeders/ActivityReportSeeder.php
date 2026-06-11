<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityReportSeeder extends Seeder
{
    public function run(): void
    {
        $tomek = User::where('email', 'tomek@example.pl')->first();
        $ania  = User::where('email', 'ania@example.pl')->first();

        $sushi = Activity::where('title', 'Warsztaty gotowania sushi')->first();
        $gra   = Activity::where('title', 'Miejska gra terenowa — odkryj Pragę!')->first();

        $reports = [
            [
                'reporter_id' => $tomek->id,
                'activity_id' => $sushi->id,
                'reason'      => 'Opis aktywności zawiera nieodpowiednie treści.',
            ],
            [
                'reporter_id' => $ania->id,
                'activity_id' => $gra->id,
                'reason'      => 'Lokalizacja wydaje się nieprawdziwa.',
            ],
        ];

        foreach ($reports as $data) {
            ActivityReport::firstOrCreate(
                ['reporter_id' => $data['reporter_id'], 'activity_id' => $data['activity_id']],
                $data
            );
        }
    }
}
