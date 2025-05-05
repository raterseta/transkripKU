<?php
namespace Database\Seeders;

use App\Models\AcademicTranscriptRequest;
use Illuminate\Database\Seeder;

class AcademicTranscriptRequestSeeder extends Seeder
{
    public function run(): void
    {
        AcademicTranscriptRequest::factory()
            ->count(3)
            ->processed()
            ->create();

        AcademicTranscriptRequest::factory()
            ->count(4)
            ->pending()
            ->create();

        AcademicTranscriptRequest::factory()
            ->count(3)
            ->create();
    }
}
