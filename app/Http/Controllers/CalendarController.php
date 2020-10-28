<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function render(Request $request) {
        $query = $request->query();
        $currentDate = new DateTime();
        if (isset($query['currentDate'])){
            $date = DateTime::createFromFormat("d.m.Y", $query['currentDate']);
        }
        else {
            $date = $currentDate;
        }
        $startDate = DateTime::createFromFormat("d.m.Y", "1.{$date->format('m.Y')}") ->format('w');
        $weeks = [];
        $week = [];

        for ($i = 1; $i < abs($startDate-5); $i++) {
            array_push($week, [
                "date" => DateTime::createFromFormat("d.m.Y", ""),
                ""
            ]);
        }
        return $date->format('w');
    }
}
