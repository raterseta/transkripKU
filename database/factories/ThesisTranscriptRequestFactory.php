<?php
namespace Database\Factories;

use App\Enums\RequestStatus;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThesisTranscriptRequestFactory extends Factory
{
    protected $model = ThesisTranscriptRequest::class;

    public function definition(): array
    {
        $statuses = array_column(RequestStatus::cases(), 'value');

        return [
            'id'                 => Str::uuid(),
            'tracking_number'    => 'TTR-' . strtoupper(Str::random(8)),
            'status'             => $this->faker->randomElement($statuses),
            'student_nim'        => $this->faker->numerify('2########'),
            'student_name'       => $this->faker->name(),
            'student_email'      => $this->faker->safeEmail(),
            'transcript_url'     => $this->faker->optional(0.6)->randomElement(['transcripts/thesis_' . Str::random(10) . '.pdf']),
            'consultation_notes' => $this->faker->optional(0.5)->paragraph(),
            'created_at'         => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at'         => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status'         => RequestStatus::SELESAI->value,
                'transcript_url' => 'transcripts/thesis_' . Str::random(10) . '.pdf',
            ];
        });
    }

    public function processing()
    {
        return $this->state(function (array $attributes) {
            return [
                'status'         => RequestStatus::PROSESKAPRODI->value,
                'transcript_url' => null,
            ];
        });
    }
}
