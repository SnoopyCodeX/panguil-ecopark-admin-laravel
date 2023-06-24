<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Reservation;
use App\Models\TouristsToGuide;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * The name of the .blade.php
     * file to be rendered
     */
    protected string $view = 'dashboard';

    public function show(Request $request)
    {
        $quickSummaries = $this->quickSummaries();
        $totalTouristsVisited = $this->totalTouristsVisited();
        $reminders = Reminder::paginate(10);
        $page = $this->view;

        if($request->ajax())
            return response()->json($reminders);

        return view("admin.$page", compact('page', 'quickSummaries', 'totalTouristsVisited', 'reminders'));
    }

    public function quickSummaries()
    {
        $totalRegisteredTouristsCount = $this->__countRegisteredTourists();
        $totalReservations = $this->__countReservations();
        $totalTouristsToGuide = $this->__countTouristsToGuide();

        $perDayRT = $this->__perDayCountRT();
        $perDayRV = $this->__perDayCountRV();
        $perDayTTG = $this->__perDayCountTTG();

        $prevCurrRT = $this->__countPrevCurrRT();
        $prevCurrRV = $this->__countPrevCurrRV();
        $prevCurrTTG = $this->__countPrevCurrTTG();

        $now = Carbon::now();
        $prev = $now->copy()->subDay();

        $percentageRT = $this->__getPercentage($prevCurrRT[$prev->format('Y-m-d')], $prevCurrRT[$now->format('Y-m-d')]);
        $percentageRV = $this->__getPercentage($prevCurrRV[$prev->format('Y-m-d')], $prevCurrRV[$now->format('Y-m-d')]);
        $percentageTTG = $this->__getPercentage($prevCurrTTG[$prev->format('Y-m-d')], $prevCurrTTG[$now->format('Y-m-d')]);

        return [
            'registered_tourists' => [
                'total_count' => $totalRegisteredTouristsCount,
                'percentage' => $this->__hasDecimal($percentageRT) ? number_format((float) $percentageRT, 2) : $percentageRT,
                'per_day_graph_count' => $perDayRT,
            ],
            'reservations' => [
                'total_count' => $totalReservations,
                'percentage' => $this->__hasDecimal($percentageRV) ? number_format((float) $percentageRV, 2) : $percentageRT,
                'per_day_graph_count' => $perDayRV,
            ],
            'tourists_to_guide' => [
                'total_count' => $totalTouristsToGuide,
                'percentage' => $this->__hasDecimal($percentageTTG) ? number_format((float) $percentageTTG, 2) : $percentageTTG,
                'per_day_graph_count' => $perDayTTG,
            ],
        ];
    }

    public function totalTouristsVisited()
    {
        $currentYear = Carbon::now()->year;
        $previousYear = $currentYear - 1;

        // Generate a range of months for each year and store the data for each month
        $yearMonthRange = [];
        foreach([$previousYear, $currentYear] as $year) {
            $currentYearData = $this->__countMonthlyDataForYear($year);

            foreach(range(1, 12) as $month) {
                $monthYear = Carbon::createFromDate($year, $month, 1)->format('M Y');
                $count = $currentYearData[Carbon::create()->month($month)->format('M')] ?? 0;
                $yearMonthRange[$year][] = [$monthYear, $count];
            }
        }

        return ['data' => $yearMonthRange];
    }




    /**
     * Helper function for counting data
     * for each month of the specified year
     */

    public function __countMonthlyDataForYear(int $year) : array
    {
        $results = TouristsToGuide::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        $data = [];

        foreach($results as $result) {
            $month = Carbon::create()->month($result->month)->format('M');
            $count = $result->count;
            $data[$month] = $count;
        }

        return $data;
    }



    /**
     * Helper functions for counting all total
     * registered tourists, reservations and
     * tourists to guide.
     *
     */

    public function __countRegisteredTourists() : int
    {
        $totaRegisteredTourists = 0;
        $chunkSize = 1000;

        do {
            $count = User::where('type', 'tourist')
                        ->select('id')
                        ->orderBy('id')
                        ->offset($totaRegisteredTourists)
                        ->limit($chunkSize)
                        ->count();

            $totaRegisteredTourists += $count;
        } while($count > 0);

        return $totaRegisteredTourists;
    }

    public function __countReservations() : int
    {
        $totalReservations = 0;
        $chunkSize = 1000;

        do {
            $count = Reservation::select('id')
                        ->orderBy('id')
                        ->offset($totalReservations)
                        ->limit($chunkSize)
                        ->count();

            $totalReservations += $count;
        } while($count > 0);

        return $totalReservations;
    }

    public function __countTouristsToGuide() : int
    {
        $totaTouristsToGuide = 0;
        $chunkSize = 1000;

        do {
            $count = TouristsToGuide::select('id')
                        ->orderBy('id')
                        ->offset($totaTouristsToGuide)
                        ->limit($chunkSize)
                        ->count();

            $totaTouristsToGuide += $count;
        } while($count > 0);

        return $totaTouristsToGuide;
    }


    /**
     * Helper functions for counting
     * rows within an 11-day range
     */


     public function __perDayCountRT() : array
     {
        $startDate = Carbon::now();
        $startOfWeek = $startDate->startOfWeek();
        $endDate = $startOfWeek->copy()->addDays(10);

        if($startDate->isSameDay($endDate)) {
            $startDate = $endDate->copy();
            $startOfWeek = $startDate->startOfWeek();
            $endDate = $startOfWeek->copy()->addDays(10);
        }

        $rangeDate = Carbon::parse($startOfWeek)->daysUntil($endDate);

        $result = [];

        $records = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                                ->where('type', 'tourist')
                                ->whereBetween('created_at', [$startOfWeek->toDateString(), $endDate->toDateString()])
                                ->groupBy(DB::raw('DATE(created_at)'))
                                ->get()
                                ->keyBy('date');

        foreach($rangeDate as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[] = [$date->format('M d Y'), $count];
        }

        return $result;
    }

    public function __perDayCountRV() : array
    {
        $startDate = Carbon::now();
        $startOfWeek = $startDate->startOfWeek();
        $endDate = $startOfWeek->copy()->addDays(10);

        if($startDate->isSameDay($endDate)) {
            $startDate = $endDate->copy();
            $startOfWeek = $startDate->startOfWeek();
            $endDate = $startOfWeek->copy()->addDays(10);
        }

        $rangeDate = Carbon::parse($startOfWeek)->daysUntil($endDate);

        $result = [];

        $records = Reservation::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                                ->whereBetween('created_at', [$startOfWeek->toDateString(), $endDate->toDateString()])
                                ->groupBy(DB::raw('DATE(created_at)'))
                                ->get()
                                ->keyBy('date');

        foreach($rangeDate as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[] = [$date->format('M d Y'), $count];
        }

        return $result;
    }

    public function __perDayCountTTG() : array
    {
        $startDate = Carbon::now();
        $startOfWeek = $startDate->startOfWeek();
        $endDate = $startOfWeek->copy()->addDays(10);

        if($startDate->isSameDay($endDate)) {
            $startDate = $endDate->copy();
            $startOfWeek = $startDate->startOfWeek();
            $endDate = $startOfWeek->copy()->addDays(10);
        }

        $rangeDate = Carbon::parse($startOfWeek)->daysUntil($endDate);

        $result = [];

        $records = TouristsToGuide::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                                ->whereBetween('created_at', [$startOfWeek->toDateString(), $endDate->toDateString()])
                                ->groupBy(DB::raw('DATE(created_at)'))
                                ->get()
                                ->keyBy('date');

        foreach($rangeDate as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[] = [$date->format('M d Y'), $count];
        }

        return $result;
    }

    /**
     * Helper functions for
     * counting data from the
     * current and previous date
     */

    public function __countPrevCurrRT() : array
    {
        $now = Carbon::now();
        $prev = $now->copy()->subDay();
        $dateRange = Carbon::parse($prev)->daysUntil($now);

        $records = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                    ->where('type', 'tourist')
                    ->whereBetween('created_at', [$prev->toDateString(), $now->addDay()->toDateString()])
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->get()
                    ->keyBy('date');

        $result = [];

        foreach($dateRange as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[$formattedDate] = $count;
        }

        return $result;
    }

    public function __countPrevCurrRV() : array
    {
        $now = Carbon::now();
        $prev = $now->copy()->subDay();
        $dateRange = Carbon::parse($prev)->daysUntil($now);

        $records = Reservation::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [$prev->toDateString(), $now->addDay()->toDateString()])
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->get()
                    ->keyBy('date');

        $result = [];

        foreach($dateRange as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[$formattedDate] = $count;
        }

        return $result;
    }

    public function __countPrevCurrTTG() : array
    {
        $now = Carbon::now();
        $prev = $now->copy()->subDay();
        $dateRange = Carbon::parse($prev)->daysUntil($now);

        $records = TouristsToGuide::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                    ->whereBetween('created_at', [$prev->toDateString(), $now->addDay()->toDateString()])
                    ->groupBy(DB::raw('DATE(created_at)'))
                    ->get()
                    ->keyBy('date');

        $result = [];

        foreach($dateRange as $date)
        {
            $formattedDate = $date->format('Y-m-d');

            $count = $records[$formattedDate]->count ?? 0;
            $result[$formattedDate] = $count;
        }

        return $result;
    }


    /**
     * Helper function for getting
     * the percentage of increase or
     * decrease in 2 values
     *
     * Formula:
     * Difference = currentCount - previousCount
     * Percentage = (Difference / previousCount) x 100
     *
     * If percentage is below 0, it means the percentage has decreased
     * Otherwise, it has increased. However, if the percentage is 0,
     * it means nothing changed since the last count.
     */
    public function __getPercentage(int $prev, int $curr) : float
    {
        // Return 0% if and only if the value of
        // $prev and $curr is 0, otherwise,
        // return 100% if only the $curr has a value
        // greater than 0.
        if($prev == 0)
            return $curr > 0 ? 100 : 0;

        $diff = $curr - $prev;
        $percentage = ($diff / $prev) * 100;

        return $percentage;
    }

    /**
     * Helper function that
     * checks if a number
     * has a decimal or none
     */
    public function __hasDecimal(int|float $number) : bool
    {
        return !is_int($number) && (floor($number) != $number);
    }
}
