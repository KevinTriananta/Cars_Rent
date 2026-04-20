<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'price_per_day',
        'status',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if car is available on specific date range
     */
    public function isAvailableBetween($startDate, $endDate)
    {
        $conflictingBooking = $this->bookings()
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $startDate);
            })
            ->whereNotIn('status', ['cancelled', 'rejected'])
            ->exists();

        return !$conflictingBooking;
    }

    /**
     * Check if car has any available dates in the next 30 days
     */
    public function hasAvailableDates()
    {
        $today = \Carbon\Carbon::today();
        $endOfMonth = $today->copy()->addDays(30);

        // Check if there's at least one day without a confirmed booking
        for ($date = $today; $date->lte($endOfMonth); $date->addDay()) {
            if ($this->isAvailableBetween($date, $date)) {
                return true;
            }
        }

        return false;
    }
}
