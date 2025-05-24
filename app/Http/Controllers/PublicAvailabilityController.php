<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicAvailabilityController extends Controller
{
    /**
     * Method to show all timeslots category wise
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->input('category_id');
        $startDate = $request->input('start_date', Carbon::today()->toDateString());

        $start = Carbon::parse($startDate);
        $days = [];
        for ($i = 0; $i < 3; $i++) {
            $days[] = $start->copy()->addDays($i);
        }

        $availabilities = Availability::when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->whereIn('date', array_map(fn($day) => $day->toDateString(), $days))
        ->with('category')
        ->get();

        $slotsByDay = [];
        foreach ($days as $day) {
            $dayString = $day->toDateString();
            $slotsByDay[$dayString] = [];

            $dayAvailabilities = $availabilities->where('date', $dayString);
            foreach ($dayAvailabilities as $availability) {
                $startTime = Carbon::parse($availability->date . ' ' . $availability->start_time);
                $endTime = Carbon::parse($availability->date . ' ' . $availability->end_time);

                while ($startTime < $endTime) {
                    $slotEnd = $startTime->copy()->addMinutes($availability->interval);
                    if ($slotEnd <= $endTime) {
                        $slotsByDay[$dayString][] = [
                            'start' => $startTime->format('H:i'),
                            'end' => $slotEnd->format('H:i'),
                            'category' => $availability->category->name,
                            'category_id' => $availability->category_id,
                        ];
                    }
                    $startTime = $slotEnd;
                }
            }
        }

        $previousStart = $start->copy()->subDays(3)->toDateString();
        $nextStart = $start->copy()->addDays(3)->toDateString();

        return view('availability.index', compact('categories', 'categoryId', 'days', 'slotsByDay', 'startDate', 'previousStart', 'nextStart'));
    }
}