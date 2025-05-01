<?php
namespace Database\Factories;

use App\Enums\RequestStatus;
use App\Models\AcademicTranscriptRequest;
use App\Models\RequestTrack;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestTrack>
 */
class RequestTrackFactory extends Factory
{
    protected $model = RequestTrack::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = array_column(RequestStatus::cases(), 'value');

        return [
            'id'                  => Str::uuid(),
            'academic_request_id' => null,
            'thesis_request_id'   => null,
            'action_notes'        => $this->faker->sentence(),
            'action_desc'         => $this->faker->randomElement([
                'Permintaan diterima',
                'Dokumen diperiksa',
                'Diteruskan ke Kaprodi',
                'Ditinjau oleh Kaprodi',
                'Dikembalikan untuk revisi',
                'Dokumen disetujui',
                'Transkrip disiapkan',
                'Transkrip dikirim',
                'Permintaan ditolak',
            ]),
            'status'              => $this->faker->randomElement($statuses),
            'created_at'          => $this->faker->dateTimeBetween('-3 months', 'now'),
            'updated_at'          => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    /**
     * Configure the factory to create a track for academic transcript request.
     *
     * @param AcademicTranscriptRequest|string $request
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forAcademicRequest($request)
    {
        $requestId = $request instanceof AcademicTranscriptRequest ? $request->id : $request;

        return $this->state(function (array $attributes) use ($requestId) {
            return [
                'academic_request_id' => $requestId,
                'thesis_request_id'   => null,
            ];
        });
    }

    /**
     * Configure the factory to create a track for thesis transcript request.
     *
     * @param ThesisTranscriptRequest|string $request
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forThesisRequest($request)
    {
        $requestId = $request instanceof ThesisTranscriptRequest ? $request->id : $request;

        return $this->state(function (array $attributes) use ($requestId) {
            return [
                'academic_request_id' => null,
                'thesis_request_id'   => $requestId,
            ];
        });
    }

    /**
     * Configure the factory for a specific status.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withStatus(string $status)
    {
        return $this->state(function (array $attributes) use ($status) {
            return [
                'status'      => $status,
                'action_desc' => $this->getActionDescForStatus($status),
            ];
        });
    }

    /**
     * Get appropriate action description based on status.
     *
     * @param string $status
     * @return string
     */
    protected function getActionDescForStatus(string $status): string
    {
        return match ($status) {
            RequestStatus::PROSESOPERATOR->value => $this->faker->randomElement([
                'Permintaan diterima oleh operator',
                'Dokumen dalam proses pemeriksaan',
                'Sedang diproses operator',
            ]),
            RequestStatus::PROSESKAPRODI->value => $this->faker->randomElement([
                'Diteruskan ke Kaprodi',
                'Dalam proses peninjauan Kaprodi',
                'Menunggu persetujuan Kaprodi',
            ]),
            RequestStatus::DIKEMBALIKANKEOPERATOR->value => $this->faker->randomElement([
                'Dikembalikan ke operator untuk pemeriksaan ulang',
                'Revisi diminta oleh Kaprodi',
                'Dokumen perlu perbaikan',
            ]),
            RequestStatus::DIKEMBALIKANKEKAPRODI->value => $this->faker->randomElement([
                'Diteruskan kembali ke Kaprodi setelah revisi',
                'Dokumen telah diperbaiki',
                'Menunggu peninjauan ulang',
            ]),
            RequestStatus::DITOLAK->value => $this->faker->randomElement([
                'Permintaan ditolak',
                'Dokumen tidak memenuhi persyaratan',
                'Tidak dapat diproses',
            ]),
            RequestStatus::SELESAI->value => $this->faker->randomElement([
                'Transkrip selesai diproses',
                'Dokumen telah dikirim',
                'Permintaan selesai',
            ]),
            default => 'Permintaan sedang diproses'
        };
    }
}
