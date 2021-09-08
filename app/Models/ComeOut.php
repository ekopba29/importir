<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComeOut extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeFilterDaily($query, $date)
    {
        return $query->whereDate('date_out', $date);
    }


    public function scopeFilterWeekly($query, $week, $month, $year)
    {
        return response()->json(['status' => 'NOK']);
    }

    public function scopeFilterMonthly($query, $month, $year)
    {
        return $query
            ->whereMonth('date_out', (string) $month)
            ->whereYear('date_out', (string) $year);
    }

    public function scopeFilterYearly($query, $year)
    {
        return $query
            ->whereYear('date_out', $year);
    }
}
