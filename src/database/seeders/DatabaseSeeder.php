<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $totalRecords = 100000;
        $chunkSize = 5000;

        $this->command->info("Starting to seed {$totalRecords} users...");

        for ($i = 0; $i < $totalRecords; $i += $chunkSize) {
            $users = [];

            $chunkUsers = User::factory()->count($chunkSize)->raw();

            $now = Carbon::now();
            foreach ($chunkUsers as $user) {
                $user['created_at'] = $now;
                $user['updated_at'] = $now;
                $users[] = $user;
            }

            User::insert($users);

            $inserted = $i + $chunkSize;
            $this->command->info("Inserted {$inserted} / {$totalRecords} users.");
        }
    }
}
