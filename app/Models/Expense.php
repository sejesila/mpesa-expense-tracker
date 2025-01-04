<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Expense extends Model
{
    use Sortable;

    public $sortable = ['withdrawn', 'date','paid_in']; // Add your sortable columns here
    protected $fillable = [
       'date', 'details', 'paid_in', 'withdrawn',
    ];
    // Add a custom accessor for the formatted date
    // Add a custom accessor for the formatted date
    public function getFormattedDateAttribute()
    {
        $date = Carbon::parse($this->attributes['date']);
        if ($date->format('H:i') == '00:00') {
            return $date->format('M jS');
        } else {
            return $date->format('M jS, gA');
        }
    }

}
