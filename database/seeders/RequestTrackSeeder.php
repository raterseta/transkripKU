<?php
namespace Database\Seeders;

use App\Enums\RequestStatus;
use App\Models\AcademicTranscriptRequest;
use App\Models\RequestTrack;
use App\Models\ThesisTranscriptRequest;
use Illuminate\Database\Seeder;

class RequestTrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate tracks for academic transcript requests
        $academicRequests = AcademicTranscriptRequest::all();

        foreach ($academicRequests as $request) {
            // First track entry is always created when request is submitted
            RequestTrack::factory()
                ->forAcademicRequest($request)
                ->withStatus(RequestStatus::PROSESOPERATOR->value)
                ->create([
                    'created_at' => $request->created_at,
                    'updated_at' => $request->created_at,
                ]);

            // Generate subsequent tracks based on current status
            $this->generateTracksForRequest($request, 'academic');
        }

        // Generate tracks for thesis transcript requests
        $thesisRequests = ThesisTranscriptRequest::all();

        foreach ($thesisRequests as $request) {
            // First track entry is always created when request is submitted
            RequestTrack::factory()
                ->forThesisRequest($request)
                ->withStatus(RequestStatus::PROSESOPERATOR->value)
                ->create([
                    'created_at' => $request->created_at,
                    'updated_at' => $request->created_at,
                ]);

            // Generate subsequent tracks based on current status
            $this->generateTracksForRequest($request, 'thesis');
        }
    }

    /**
     * Generate tracks for a request based on its current status.
     *
     * @param AcademicTranscriptRequest|ThesisTranscriptRequest $request
     * @param string $type
     * @return void
     */
    private function generateTracksForRequest($request, string $type): void
    {
        $currentStatus = $request->status;
        $trackDates    = [];

        $startDate = $request->created_at;
        $endDate   = $request->updated_at;
        $daysDiff  = $startDate->diffInDays($endDate);

        switch ($currentStatus) {
            case RequestStatus::SELESAI->value:

                $hadReturn = (rand(0, 100) > 20);

                if ($daysDiff > 3) {
                    $trackDates[] = [
                        'status' => RequestStatus::PROSESKAPRODI->value,
                        'date'   => $startDate->copy()->addDays(rand(1, max(1, $daysDiff - 2))),
                    ];

                    if ($hadReturn && $daysDiff > 5) {
                        $returnDate = $trackDates[0]['date']->copy()->addDays(rand(1, 2));

                        $trackDates[] = [
                            'status' => RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                            'date'   => $returnDate,
                        ];

                        $trackDates[] = [
                            'status' => RequestStatus::PROSESOPERATOR->value,
                            'date'   => $returnDate->copy()->addDays(1),
                        ];

                        $trackDates[] = [
                            'status' => RequestStatus::PROSESKAPRODI->value,
                            'date'   => $returnDate->copy()->addDays(2),
                        ];
                    }

                    $trackDates[] = [
                        'status' => RequestStatus::SELESAI->value,
                        'date'   => $endDate,
                    ];
                } else {
                    $trackDates[] = [
                        'status' => RequestStatus::PROSESKAPRODI->value,
                        'date'   => $startDate->copy()->addHours(rand(2, 8)),
                    ];

                    $trackDates[] = [
                        'status' => RequestStatus::SELESAI->value,
                        'date'   => $endDate,
                    ];
                }
                break;

            case RequestStatus::DITOLAK->value:
                $trackDates[] = [
                    'status' => RequestStatus::PROSESKAPRODI->value,
                    'date'   => $startDate->copy()->addDays(rand(1, max(1, $daysDiff - 1))),
                ];

                $trackDates[] = [
                    'status' => RequestStatus::DITOLAK->value,
                    'date'   => $endDate,
                ];
                break;

            case RequestStatus::PROSESKAPRODI->value:
                $trackDates[] = [
                    'status' => RequestStatus::PROSESKAPRODI->value,
                    'date'   => $endDate,
                ];
                break;

            case RequestStatus::DIKEMBALIKANKEOPERATOR->value:
                $trackDates[] = [
                    'status' => RequestStatus::PROSESKAPRODI->value,
                    'date'   => $startDate->copy()->addDays(rand(1, max(1, $daysDiff - 1))),
                ];

                $trackDates[] = [
                    'status' => RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                    'date'   => $endDate,
                ];
                break;

            case RequestStatus::DIKEMBALIKANKEKAPRODI->value:
                $trackDates[] = [
                    'status' => RequestStatus::PROSESKAPRODI->value,
                    'date'   => $startDate->copy()->addDays(rand(1, max(1, $daysDiff - 2))),
                ];

                $trackDates[] = [
                    'status' => RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                    'date'   => $startDate->copy()->addDays(rand(1, max(1, $daysDiff - 1))),
                ];

                $trackDates[] = [
                    'status' => RequestStatus::DIKEMBALIKANKEKAPRODI->value,
                    'date'   => $endDate,
                ];
                break;
        }

        foreach ($trackDates as $track) {
            $factoryInstance = RequestTrack::factory()->withStatus($track['status']);

            if ($type === 'academic') {
                $factoryInstance->forAcademicRequest($request);
            } else {
                $factoryInstance->forThesisRequest($request);
            }

            $factoryInstance->create([
                'created_at' => $track['date'],
                'updated_at' => $track['date'],
            ]);
        }
    }
}
