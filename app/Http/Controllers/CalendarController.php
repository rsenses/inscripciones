<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Components\Calendar;

class CalendarController extends Controller
{
    public function show(Product $product) {
        $calendar = Calendar::create($product->name)
            ->event(Event::create($product->name)
                ->startsAt($product->start_date)
                ->endsAt($product->end_date)
        );

        return response($calendar->get(), 200, [
           'Content-Type' => 'text/calendar',
           'Content-Disposition' => 'attachment; filename="' . Str::slug($product->name, '-') . '.ics"',
           'charset' => 'utf-8',
        ]);
    }
}
