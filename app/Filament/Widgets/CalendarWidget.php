<?php

namespace App\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Leave;

use function PHPSTORM_META\map;

class CalendarWidget extends FullCalendarWidget
{

    protected function getHeading(): string
    {
        return 'Statistic';
    }

    // use CanManageEvents;
    /**
     * FullCalendar will call this function whenever it needs new event data.
     * This is triggered when the user clicks prev/next or switches views on the calendar.
     */
    public static function fetchEvents(array $fetchInfo): array
    {
        $leave = Leave::where('user_id', auth()->user()->id)->get();

        clock()->info("leave", $leave->toArray());
        // You can use $fetchInfo to filter events by date.

        $data = collect($leave)->map(function ($address) {

            clock()->info("info", $address->toArray());

            $arrray = [
                'al' => 'Annual',
                'sl' => 'Sick',
                'hl' => 'Hospitalisation',
                'pl' => 'Paternity',
                'cl' => 'Compassionate leave'
            ];
            $title = $arrray[$address["category"]] . " (" . $address['status'] . ") " ;
            if ($address['reason'] !== "") {
                $title = "- " . $title . $address['reason'];
            }
            // if ()
            return [
                'id' => $address["leaves_id"],
                'title' => $title ,
                'start' => $address["start_date"],
                'end' => $address["end_date"],
            ];

            return $address;
        
        });
        // $data = $leave.map( function($value) { 
        //     return [
        //         'id' => 1,
        //         'title' => 'AL',
        //         'start' => now()
		//     ];
        // });

        return $data->toArray();
        return [ 
            [
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
		]
        ];    
    
    }

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