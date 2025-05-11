<?php
namespace App\Services;

use App\Models\ThesisTranscriptRequest;
use Carbon\Carbon;

class CalendarEventService
{
    /**
     * Generate Google Calendar add event URL
     * This creates a URL that when clicked will prompt to add event to Google Calendar
     */
    public function generateGoogleCalendarUrl(ThesisTranscriptRequest $request): string
    {
        $consultationDate = Carbon::parse($request->consultation_date);
        $endTime          = (clone $consultationDate)->addHour();

        $params = [
            'action'  => 'TEMPLATE',
            'text'    => 'Konsultasi Transkrip Final - ' . $request->student_name,
            'dates'   => $consultationDate->format('Ymd\THis') . '/' . $endTime->format('Ymd\THis'),
            'details' => "Konsultasi Transkrip Final\n" .
            "Mahasiswa: {$request->student_name}\n" .
            "NIM: {$request->student_nim}\n" .
            "Tracking: {$request->tracking_number}" .
            (isset($request->consultation_notes) && ! empty($request->consultation_notes) ? "\nCatatan: {$request->consultation_notes}" : ''),
        ];

        if (! isset($request->consultation_notes) || ! str_contains(strtolower($request->consultation_notes), 'lokasi') &&
            ! str_contains(strtolower($request->consultation_notes), 'tempat')) {
            $params['location'] = 'Kepala Program Studi';
        }

        return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
    }

    /**
     * Generate an iCalendar (.ics) file content for email attachment
     */
    public function generateCalendarInvite(ThesisTranscriptRequest $request): string
    {
        $consultationDate = Carbon::parse($request->consultation_date);
        $endTime          = (clone $consultationDate)->addHour();
        $uid              = uniqid() . '@' . parse_url(config('app.url'), PHP_URL_HOST);
        $now              = Carbon::now()->format('Ymd\THis\Z');

        $description = "Konsultasi Transkrip Final untuk {$request->student_name} ({$request->student_nim})";
        if (isset($request->consultation_notes) && ! empty($request->consultation_notes)) {
            $description .= "\nCatatan: {$request->consultation_notes}";
        }

        $location = 'Kepala Program Studi';
        if (isset($request->consultation_notes) &&
            (str_contains(strtolower($request->consultation_notes), 'lokasi') ||
                str_contains(strtolower($request->consultation_notes), 'tempat'))) {
            $location = '';
        }

        $ics = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//TranskripKU//Konsultasi Transkrip//ID',
            'CALSCALE:GREGORIAN',
            'METHOD:REQUEST',
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . $now,
            'DTSTART:' . $consultationDate->format('Ymd\THis'),
            'DTEND:' . $endTime->format('Ymd\THis'),
            'SUMMARY:Konsultasi Transkrip Final - ' . $request->student_name,
            'DESCRIPTION:' . $this->formatIcsText($description),
        ];

        if (! empty($location)) {
            $ics[] = 'LOCATION:' . $location;
        }

        $ics = array_merge($ics, [
            'STATUS:CONFIRMED',
            'ORGANIZER;CN=Kepala Program Studi:mailto:noreply@transkripku.ub.ac.id',
            'ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE:mailto:' . $request->student_email,
            'BEGIN:VALARM',
            'ACTION:DISPLAY',
            'DESCRIPTION:Reminder',
            'TRIGGER:-PT30M',
            'END:VALARM',
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        return implode("\r\n", $ics);
    }

    /**
     * Generate an Outlook Web add event URL
     */
    public function generateOutlookCalendarUrl(ThesisTranscriptRequest $request): string
    {
        $consultationDate = Carbon::parse($request->consultation_date);
        $endTime          = (clone $consultationDate)->addHour(); // Default 1 hour consultation

        $body = "Konsultasi Transkrip Final\n" .
            "Mahasiswa: {$request->student_name}\n" .
            "NIM: {$request->student_nim}\n" .
            "Tracking: {$request->tracking_number}";

        if (isset($request->consultation_notes) && ! empty($request->consultation_notes)) {
            $body .= "\nCatatan: {$request->consultation_notes}";
        }

        $params = [
            'path'    => '/calendar/action/compose',
            'rru'     => 'addevent',
            'startdt' => $consultationDate->format('Y-m-d\TH:i:s'),
            'enddt'   => $endTime->format('Y-m-d\TH:i:s'),
            'subject' => 'Konsultasi Transkrip Final - ' . $request->student_name,
            'body'    => $body,
        ];

        if (! isset($request->consultation_notes) || ! str_contains(strtolower($request->consultation_notes), 'lokasi') &&
            ! str_contains(strtolower($request->consultation_notes), 'tempat')) {
            $params['location'] = 'Program Studi';
        }

        return 'https://outlook.live.com/calendar/0/?' . http_build_query($params);
    }

    /**
     * Format text for iCalendar format (handling newlines and other special characters)
     */
    private function formatIcsText(string $text): string
    {
        $text = str_replace("\n", "\\n", $text);

        $text = str_replace(",", "\\,", $text);
        $text = str_replace(";", "\\;", $text);

        return $text;
    }
}
