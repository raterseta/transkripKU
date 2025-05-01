<?php
namespace Database\Seeders;

use App\Models\ThesisTranscriptRequest;
use Illuminate\Database\Seeder;

class ThesisTranscriptRequestSeeder extends Seeder
{
    public function run(): void
    {
        ThesisTranscriptRequest::factory()
            ->count(4)
            ->completed()
            ->create();

        ThesisTranscriptRequest::factory()
            ->count(3)
            ->processing()
            ->create();

        ThesisTranscriptRequest::factory()
            ->count(3)
            ->create();
    }
}
