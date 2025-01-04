<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Expense extends Model
{
    use Sortable;

    public $sortable = ['withdrawn', 'date','paid_in','details']; // Add your sortable columns here
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

    // Add a custom accessor for the formatted details
    // Add a custom accessor for the formatted details
    public function getFormattedDetailsAttribute()
    {
        $fieldValue = $this->attributes['details'];
        preg_match('/\d(?!.*\d)(.*)$/', $fieldValue, $matches);
        $extractedValue = isset($matches[1]) ? trim($matches[1]) : $fieldValue;

        // Capitalize the first letter of each word
        return ucwords(strtolower($extractedValue));
    }
    public function getFormattedPaybillAttribute()
    {
        $fieldValue = $this->attributes['details'];

        // Use a regular expression to capture everything after "Pay Bill To" or "Pay Bill to"
        preg_match('/Pay Bill [Tt]o\s*(.*)$/', $fieldValue, $matches);
        $extractedValue = isset($matches[1]) ? trim($matches[1]) : $fieldValue;

        // Capitalize the first letter of each word
        return ucwords(strtolower($extractedValue));
    }
    public function getFormattedMerchantDetailsAttribute()
    {
        $fieldValue = $this->attributes['details'];

        // Use a regular expression to capture everything after the hyphen, excluding the space
        preg_match('/-\s*(.*)$/', $fieldValue, $matches);
        $extractedValue = isset($matches[1]) ? trim($matches[1]) : $fieldValue;

        // Capitalize the first letter of each word
        return ucwords(strtolower($extractedValue));
    }


}
