<?php
namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StudyProgram::create([
            'name' => 'Sistem Informasi',
        ]);
        StudyProgram::create([
            'name' => 'Teknologi Informasi',
        ]);
        StudyProgram::create([
            'name' => 'Pendidikan Teknologi Informasi',
        ]);
        StudyProgram::create([
            'name' => 'Teknik Informatika',
        ]);
        StudyProgram::create([
            'name' => 'Teknik Komputer',
        ]);
    }
}
