<?php
namespace App\Services;

use App\Models\Note;
use Carbon\Carbon;

class NoteService {

    /**
    * Get notes with associated deals for a specific period.
    *
    * This method retrieves notes and their associated deal names within a specified time period.
    * The number of results returned can be limited by the $limit parameter.
    *
    * @param string $startDate The start date of the period (format: Y-m-d).
    * @param string $endDate The end date of the period (format: Y-m-d).
    * @param int $limit The maximum number of notes to retrieve.
    * @return \Illuminate\Support\Collection A collection of notes with associated deal names.
    */
    public function getNotesWithDealsForPeriod($startDate, $endDate, $limit)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        return Note::join('deals', 'notes.deal_id', '=', 'deals.id')
            ->whereBetween('notes.created_at', [$start, $end])
            ->select(
                'deals.deal_name as deal_name',
                'notes.note_content as note',
            )
            ->take($limit)
            ->get();
    }
}