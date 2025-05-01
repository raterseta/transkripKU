<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StudyProgramSeeder::class,
            UserSeeder::class,
            AcademicTranscriptRequestSeeder::class,
            ThesisTranscriptRequestSeeder::class,
            RequestTrackSeeder::class,
        ]);
    }
}
