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
        $academicRequests = AcademicTranscriptRequest::all();

        foreach ($academicRequests as $request) {
            RequestTrack::factory()
                ->forAcademicRequest($request)
                ->withStatus(RequestStatus::PROSESOPERATOR->value)
                ->create([
                    'tracking_number' => $request->tracking_number,
                    'created_at'      => $request->created_at,
                    'updated_at'      => $request->created_at,
                ]);

            $this->generateTracksForRequest($request, 'academic');
        }

        $thesisRequests = ThesisTranscriptRequest::all();

        foreach ($thesisRequests as $request) {
            RequestTrack::factory()
                ->forThesisRequest($request)
                ->withStatus(RequestStatus::PROSESOPERATOR->value)
                ->create([
                    'tracking_number' => $request->tracking_number,
                    'created_at'      => $request->created_at,
                    'updated_at'      => $request->created_at,
                ]);

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

        // Always start with diproses_operator
        $trackDates[] = [
            'status'      => RequestStatus::PROSESOPERATOR->value,
            'date'        => $startDate,
            'action_desc' => 'Diproses Operator',
        ];

        $willBeRejected = rand(1, 10) === 1; // 10% chance of rejection
        $rejectionPoint = rand(2, 4);        // Can happen after operator, kaprodi, or during return

        $willBeReturned = ! $willBeRejected && rand(1, 3) === 1; // 33% chance of return if not rejected

        $isFinalRequest = $type === 'thesis' && rand(1, 2) === 1; // 50% chance for thesis requests

        $currentDate = $startDate->copy()->addDays(rand(1, 2));

        $trackDates[] = [
            'status'      => RequestStatus::PROSESKAPRODI->value,
            'date'        => $currentDate,
            'action_desc' => 'Diproses Kaprodi',
        ];

        if ($willBeRejected && $rejectionPoint === 2) {
            $trackDates[] = [
                'status'      => RequestStatus::DITOLAK->value,
                'date'        => $currentDate->copy()->addDays(1),
                'action_desc' => 'Ditolak',
            ];
            return;
        }

        $currentDate = $currentDate->copy()->addDays(rand(1, 2));

        if ($isFinalRequest) {
            $trackDates[] = [
                'status'      => RequestStatus::MENUNGGUKONSULTASI->value,
                'date'        => $currentDate,
                'action_desc' => 'Menunggu Konsultasi',
            ];
            $currentDate = $currentDate->copy()->addDays(rand(2, 3));
        }

        if ($willBeReturned) {
            $trackDates[] = [
                'status'      => RequestStatus::DIKEMBALIKANKEOPERATOR->value,
                'date'        => $currentDate,
                'action_desc' => 'Dikembalikan ke Operator',
            ];

            if ($willBeRejected && $rejectionPoint === 3) {
                $trackDates[] = [
                    'status'      => RequestStatus::DITOLAK->value,
                    'date'        => $currentDate->copy()->addDays(1),
                    'action_desc' => 'Ditolak',
                ];
                return;
            }

            $currentDate = $currentDate->copy()->addDays(1);

            $trackDates[] = [
                'status'      => RequestStatus::PROSESOPERATOR->value,
                'date'        => $currentDate,
                'action_desc' => 'Diproses Operator',
            ];

            $currentDate = $currentDate->copy()->addDays(1);

            $trackDates[] = [
                'status'      => RequestStatus::PROSESKAPRODI->value,
                'date'        => $currentDate,
                'action_desc' => 'Diproses Kaprodi',
            ];

            $currentDate = $currentDate->copy()->addDays(rand(1, 2));
        }

        $trackDates[] = [
            'status'      => RequestStatus::DITERUSKANKEOPERATOR->value,
            'date'        => $currentDate,
            'action_desc' => 'Diteruskan ke Operator',
        ];

        if ($willBeRejected && $rejectionPoint === 4) {
            $trackDates[] = [
                'status'      => RequestStatus::DITOLAK->value,
                'date'        => $currentDate->copy()->addDays(1),
                'action_desc' => 'Ditolak',
            ];
            return;
        }

        $trackDates[] = [
            'status'      => RequestStatus::SELESAI->value,
            'date'        => $endDate,
            'action_desc' => 'Selesai',
        ];

        foreach ($trackDates as $track) {
            $factoryInstance = RequestTrack::factory()->withStatus($track['status']);

            $data = [
                'tracking_number' => $request->tracking_number,
                'created_at'      => $track['date'],
                'updated_at'      => $track['date'],
                'action_desc'     => $track['action_desc'],
            ];

            if ($type === 'academic') {
                $factoryInstance                        = $factoryInstance->forAcademicRequest($request);
                $data['academic_transcript_request_id'] = $request->id;
                $data['thesis_transcript_request_id']   = null;
            } else {
                $factoryInstance                        = $factoryInstance->forThesisRequest($request);
                $data['academic_transcript_request_id'] = null;
                $data['thesis_transcript_request_id']   = $request->id;
            }

            if (empty($data['academic_transcript_request_id']) && empty($data['thesis_transcript_request_id'])) {
                throw new \Exception('Track must be linked to a request!');
            }

            $factoryInstance->create($data);
        }
    }
}
