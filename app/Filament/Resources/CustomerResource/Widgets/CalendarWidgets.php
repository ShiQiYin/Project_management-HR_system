<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class PersonalCalendarWidget extends FullCalendarWidget
{

    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public function fetchEvents(array $fetchInfo): array
    {
		// $schedules = Appointment::query()
        // ->where([
        //     ['start_at', '>=', $fetchInfo['start']],
        //     ['end_at', '<', $fetchInfo['end']],
        // ])
        // ->get();

    	// $data = $schedules->map([]);

        // You can use $fetchInfo to filter events by date.
        return [ [
			'id' => 1,
			'title' => 'AL',
			'start' => now()
		],
		[
			'id' => 2,
			'title' => 'AL',
			'start' => now()->addDay(),
			'end' => now()->addDay(),
			// 'url' => 'https://some-url.com',
			// 'shouldOpenInNewTab' => true,
		]];
    }
    /**
     * Return events that should be rendered statically on calendar.
     */
    // public function getViewData(): array
    // {
    //     return [
    //         [
    //             'id' => 1,
    //             'title' => 'AL',
    //             'start' => now()
    //         ],
    //         [
    //             'id' => 2,
    //             'title' => 'AL',
    //             'start' => now()->addDay(),
    //             'end' => now()->addDay(),
    //             // 'url' => 'https://some-url.com',
    //             // 'shouldOpenInNewTab' => true,
    //         ]
    //     ];
    // }

    public static function canCreate(): bool
    {
        // Returning 'false' will remove the 'Create' button on the calendar.
        return false;
    }

    public static function canEdit(?array $event = null): bool
    {
        // Returning 'false' will disable the edit modal when clicking on a event.
        return false;
    }
}