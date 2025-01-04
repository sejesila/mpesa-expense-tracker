<?php

namespace App\Imports;

use App\Models\Expense;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ExpensesImport implements ToModel, WithChunkReading, ShouldQueue, WithHeadingRow, SkipsEmptyRows, WithBatchInserts
{
    use Importable;

    /**
     * @param array $row
     *
     * @return Expense
     */
    public function model(array $row): ?Expense
    {
        try {
// Check if 'paid_in' and 'withdrawn' are present and numeric
            $paidIn = isset($row['paid_in']) && is_numeric($row['paid_in']) ? $row['paid_in'] : null;
            $withdrawn = isset($row['withdrawn']) && is_numeric($row['withdrawn']) ? abs($row['withdrawn']) : null;
            // Transform the date field
            $date = Date::excelToDateTimeObject($row['date'])->format('Y-m-d H:i');

            // Check if the 'details' column contains a specific string (case-insensitive)
          //  if (Str::contains(Str::lower($row['details']), 'pay bill to')) {
// Perform computation on the 'paid_in' column
//$computedValue = $paidIn * 2; // Example computation

// Save to db
                return new Expense([
                    'date' => $date,
                    'details' => $row['details'],
                    'paid_in' => $paidIn,
                    'withdrawn' => $withdrawn,
                    //'computed_column' => $computedValue,
                ]);
         //   } else {


        } catch (\Exception $e) {
            Log::error('Error importing row: ' . $e->getMessage());
        }
        return null;
    }

    /**
     * Specify the chunk size for reading the file.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 50; // Adjust the chunk size as needed
    }

    public function batchSize(): int
    {
       return 50;
    }
}
