<?php
namespace Database\Seeders;

use App\Models\StudyProgram;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sistemInformasi = StudyProgram::where('name', 'Sistem Informasi')->first();

        User::factory()->create([
            'name'             => 'Test User',
            'email'            => 'test@example.com',
            'nip'              => '1111111',
            'study_program_id' => $sistemInformasi->id,
        ]);
    }
}
