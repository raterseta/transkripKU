<?php
namespace Database\Factories;

use App\Enums\RequestStatus;
use App\Enums\SignatureType;
use App\Models\AcademicTranscriptRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicTranscriptRequest>
 */
class AcademicTranscriptRequestFactory extends Factory
{
    protected $model = AcademicTranscriptRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses       = array_column(RequestStatus::cases(), 'value');
        $signatureTypes = array_column(SignatureType::cases(), 'value');

        return [
            'id'              => Str::uuid(),
            'tracking_number' => 'ATR-' . strtoupper(Str::random(8)),
            'status'          => $this->faker->randomElement($statuses),
            'student_nim'     => $this->faker->numerify('2########'),
            'student_name'    => $this->faker->name(),
            'student_email'   => $this->faker->safeEmail(),
            'needs'           => $this->faker->randomElement(['Job Application', 'Scholarship', 'Further Study', 'Personal Records']),
            'signature_type'  => $this->faker->randomElement($signatureTypes),
            'transcript_url'  => $this->faker->randomElement([null, 'transcripts/academic_' . Str::random(10) . '.pdf']),
            'retrieval_notes' => $this->faker->optional(0.7)->sentence(),
            'created_at'      => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at'      => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    /**
     * Indicate that the request has been processed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function processed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status'         => RequestStatus::SELESAI->value,
                'transcript_url' => 'transcripts/academic_' . Str::random(10) . '.pdf',
            ];
        });
    }

    /**
     * Indicate that the request is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status'         => RequestStatus::PROSESOPERATOR->value,
                'transcript_url' => null,
            ];
        });
    }
}
