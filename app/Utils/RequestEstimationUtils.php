<?php
namespace App\Utils;

use App\Enums\RequestStatus;
use Carbon\Carbon;

class RequestEstimationUtils
{
    public static function getEstimatedCompletion($record, int $workingDaysDeadline): array
    {
        if (! $record || ! $record->created_at) {
            return ['date' => null, 'days_remaining' => 0, 'is_urgent' => false];
        }

        if ($record->status === RequestStatus::SELESAI) {
            return [
                'date'           => null,
                'days_remaining' => 0,
                'is_urgent'      => false,
                'is_overdue'     => false,
                'is_completed'   => true,
            ];
        }

        if ($record->status === RequestStatus::DITOLAK) {
            return [
                'date'           => null,
                'days_remaining' => 0,
                'is_urgent'      => false,
                'is_overdue'     => false,
                'is_rejected'    => true,
            ];
        }

        $startDate = Carbon::parse($record->created_at);
        $today     = Carbon::now();

        $estimatedDate = $startDate->copy();
        $daysAdded     = 0;

        while ($daysAdded < $workingDaysDeadline) {
            $estimatedDate->addDay();
            if ($estimatedDate->dayOfWeek !== 0 && $estimatedDate->dayOfWeek !== 6) {
                $daysAdded++;
            }
        }

        $isOverdue   = $today->gt($estimatedDate);
        $overdueDays = 0;

        if ($isOverdue) {
            $currentDate = $estimatedDate->copy();
            while ($currentDate->lt($today)) {
                if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                    $overdueDays++;
                }
                $currentDate->addDay();
            }
        }

        $currentDate       = $startDate->copy();
        $workingDaysPassed = 0;

        while ($currentDate->lt($today)) {
            if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                $workingDaysPassed++;
            }
            $currentDate->addDay();
        }

        // Add partial day if today is a working day
        if ($today->dayOfWeek !== 0 && $today->dayOfWeek !== 6) {
            $workingDaysPassed += $today->diffInHours($today->copy()->startOfDay()) / 24;
        }

        $workingDaysRemaining = $workingDaysDeadline - $workingDaysPassed;
        $hoursRemaining       = $workingDaysRemaining * 24;

        if (! $isOverdue) {
            $currentDate    = $today->copy();
            $hoursRemaining = 0;

            while ($currentDate->lt($estimatedDate)) {
                if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                    $hoursRemaining += 24;
                }
                $currentDate->addDay();
            }

            if ($today->dayOfWeek !== 0 && $today->dayOfWeek !== 6) {
                $hoursRemaining += $today->diffInHours($today->copy()->endOfDay());
            }
        }

        $daysRemaining = $isOverdue ? -$overdueDays : round($hoursRemaining / 24, 1);

        $urgencyThreshold = $workingDaysDeadline > 5 ? 48 : 24;
        $isUrgent         = $isOverdue ? true : $hoursRemaining <= $urgencyThreshold;

        return [
            'date'            => $estimatedDate,
            'days_remaining'  => $daysRemaining,
            'hours_remaining' => $hoursRemaining,
            'is_urgent'       => $isUrgent,
            'is_overdue'      => $isOverdue,
            'overdue_days'    => $overdueDays,
            'total_days'      => $workingDaysDeadline,
            'days_passed'     => round($workingDaysPassed, 1),
        ];
    }

    public static function calculateProcessingTime($record): string
    {
        if (! $record || ! $record->created_at) {
            return '-';
        }

        $startDate = Carbon::parse($record->created_at);
        $today     = Carbon::now();

        if ($startDate->isSameDay($today)) {
            $hoursSinceCreated = $startDate->diffInHours($today);
            return round($hoursSinceCreated) . ' jam sejak pengajuan';
        }

        $hoursSinceCreated = 0;
        $currentDate       = $startDate->copy();

        if ($startDate->dayOfWeek !== 0 && $startDate->dayOfWeek !== 6) {
            $hoursSinceCreated += $startDate->diffInHours($startDate->copy()->endOfDay());
        }

        $currentDate->addDay();
        while ($currentDate->lt($today)) {
            if ($currentDate->dayOfWeek !== 0 && $currentDate->dayOfWeek !== 6) {
                $hoursSinceCreated += 24;
            }
            $currentDate->addDay();
        }

        if ($today->dayOfWeek !== 0 && $today->dayOfWeek !== 6) {
            $hoursSinceCreated += $today->copy()->startOfDay()->diffInHours($today);
        }

        if ($hoursSinceCreated < 24) {
            return round($hoursSinceCreated) . ' jam sejak pengajuan';
        }

        return round($hoursSinceCreated / 24) . ' hari kerja sejak pengajuan';
    }

    public static function getEstimatedCompletionDisplay($record, int $workingDaysDeadline): string
    {
        if (! $record) {
            return '-';
        }

        if ($record->status === RequestStatus::SELESAI) {
            return "✅ Selesai";
        }
        if ($record->status === RequestStatus::DITOLAK) {
            return "❌ Ditolak";
        }

        $estimation = static::getEstimatedCompletion($record, $workingDaysDeadline);
        if (! $estimation['date']) {
            return '-';
        }

        $dateStr = $estimation['date']->format('d M Y');

        if ($estimation['is_overdue']) {
            return "🔴 {$dateStr} (Terlambat " . abs($estimation['overdue_days']) . " hari kerja)";
        } elseif ($estimation['is_urgent']) {
            $timeRemaining = $estimation['hours_remaining'] < 24
            ? round($estimation['hours_remaining']) . ' jam lagi'
            : round($estimation['days_remaining']) . ' hari kerja lagi';
            return "🟡 {$dateStr} ({$timeRemaining} - URGENT)";
        } else {
            return "🟢 {$dateStr}";
        }
    }

    public static function getPriorityIndicator($record, int $workingDaysDeadline): string
    {
        if (! $record) {
            return '-';
        }

        if ($record->status === RequestStatus::SELESAI) {
            return '✅ Selesai';
        }
        if ($record->status === RequestStatus::DITOLAK) {
            return '❌ Ditolak';
        }

        $estimation = static::getEstimatedCompletion($record, $workingDaysDeadline);

        if ($estimation['is_overdue']) {
            return '🚨 SANGAT URGENT - Terlambat ' . abs($estimation['overdue_days']) . ' hari kerja';
        } elseif ($estimation['is_urgent']) {
            return '⚠️ URGENT - Segera Diselesaikan';
        } else {
            return '✅ Normal';
        }
    }

    public static function getPriorityIndicatorForThesis($record, int $workingDaysDeadline): string
    {
        if (! $record) {
            return '-';
        }

        $estimation = static::getEstimatedCompletion($record, $workingDaysDeadline);

        if (isset($estimation['is_completed'])) {
            return '✅ Selesai';
        }
        if (isset($estimation['is_rejected'])) {
            return '❌ Ditolak';
        }

        if ($estimation['is_overdue']) {
            return '🚨 SANGAT URGENT - Terlambat ' . abs($estimation['overdue_days']) . ' hari kerja';
        } elseif ($estimation['is_urgent']) {
            return '⚠️ URGENT - Segera Diselesaikan';
        } else {
            return '✅ Normal';
        }
    }
}
