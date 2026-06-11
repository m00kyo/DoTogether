<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@dotogether.pl')->first();
        $ania = User::where('email', 'ania@example.pl')->first();
        $marek = User::where('email', 'marek@example.pl')->first();
        $zofia = User::where('email', 'zofia@example.pl')->first();
        $tomek = User::where('email', 'tomek@example.pl')->first();

        $sport = Category::where('name', 'Sport')->first();
        $kulinaria = Category::where('name', 'Kulinaria')->first();
        $kultura = Category::where('name', 'Kultura')->first();
        $przyroda = Category::where('name', 'Przyroda')->first();
        $sztuka = Category::where('name', 'Sztuka')->first();
        $gry = Category::where('name', 'Gry terenowe')->first();

        $activities = [
            [
                'title' => 'Poranny bieg w parku Łazienkowskim',
                'description' => 'Zapraszam na wspólny bieg o poranku. Trasa 5 km, tempo umiarkowane — wszyscy są mile widziani!',
                'event_date' => '2026-07-05',
                'lat' => 52.21520,
                'long' => 21.03548,
                'location' => 'Park Łazienkowski, Warszawa',
                'max_participants' => 15,
                'required_age' => null,
                'category_id' => $sport->id,
                'creator_id' => $ania->id,
            ],
            [
                'title' => 'Warsztaty gotowania sushi',
                'description' => 'Nauczymy się razem jak przygotować tradycyjne japońskie sushi. Wszystkie składniki zapewnione!',
                'event_date' => '2026-07-12',
                'lat' => 52.22977,
                'long' => 21.01178,
                'location' => 'Centrum Warszawa, ul. Krucza 10',
                'max_participants' => 10,
                'required_age' => null,
                'category_id' => $kulinaria->id,
                'creator_id' => $marek->id,
            ],
            [
                'title' => 'Wyjście do Teatru Narodowego',
                'description' => 'Wspólne wyjście na spektakl "Dziady" w Teatrze Narodowym. Spotykamy się przed wejściem o 18:30.',
                'event_date' => '2026-07-18',
                'lat' => 52.24115,
                'long' => 21.01417,
                'location' => 'Teatr Narodowy, Warszawa',
                'max_participants' => 8,
                'required_age' => null,
                'category_id' => $kultura->id,
                'creator_id' => $zofia->id,
            ],
            [
                'title' => 'Wycieczka do Kampinoskiego Parku Narodowego',
                'description' => 'Całodniowa wycieczka piesza przez Puszczę Kampinoską. Dystans ~18 km. Zabrać prowiant i dobre buty!',
                'event_date' => '2026-07-26',
                'lat' => 52.32500,
                'long' => 20.58300,
                'location' => 'Kampinoski Park Narodowy, Izabelin',
                'max_participants' => 20,
                'required_age' => null,
                'category_id' => $przyroda->id,
                'creator_id' => $tomek->id,
            ],
            [
                'title' => 'Wieczór z malowaniem akwarelami',
                'description' => 'Spokojny wieczór twórczy — malujemy akwarelami dla relaksu. Brak doświadczenia? Niestraszne!',
                'event_date' => '2026-08-02',
                'lat' => 52.23050,
                'long' => 21.00850,
                'location' => 'Pracownia Sztuki Wspólnej, Warszawa',
                'max_participants' => 12,
                'required_age' => null,
                'category_id' => $sztuka->id,
                'creator_id' => $zofia->id,
            ],
            [
                'title' => 'Miejska gra terenowa — odkryj Pragę!',
                'description' => 'Gra w stylu escape room, ale po ulicach prawobrzeżnej Warszawy. Drużyny 3-4 osobowe.',
                'event_date' => '2026-08-09',
                'lat' => 52.25570,
                'long' => 21.03620,
                'location' => 'Plac Wileński, Warszawa',
                'max_participants' => 2,
                'required_age' => null,
                'category_id' => $gry->id,
                'creator_id' => $marek->id,
            ],
            [
                'title' => 'Meetup społeczności DoTogether',
                'description' => 'Oficjalne spotkanie integracyjne społeczności DoTogether. Poznaj innych użytkowników, podziel się pomysłami i dobrze się baw!',
                'event_date' => '2026-09-06',
                'lat' => 52.23194,
                'long' => 21.00663,
                'location' => 'Centrum Zarządzania Innowacjami, Warszawa',
                'max_participants' => 4,
                'required_age' => null,
                'category_id' => $kultura->id,
                'creator_id' => $admin->id,
            ],
        ];

        foreach ($activities as $data) {
            Activity::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
