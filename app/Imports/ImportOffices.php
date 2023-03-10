<?php

namespace App\Imports;

use App\Models\Office;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use DB;

class ImportOffices implements ToModel, WithHeadingRow, WithUpsertColumns
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $offices = DB::table('office')->get();
    
        // Get all bin number from the $bin collection
        $name = $offices->pluck('name');
        
        // Checking if the bin number is already in the database
        if ($name->contains($row['name']) == false) 
        try {
            return new Office([
                'name' => $row['name'],
                'price' => $row['price'],
                'offices' => $row['offices'],
                'tables' => $row['tables'],
                'sqm' => $row['sqm']
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        else null; // if the bin number is already in the database, return null
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function upsertColumns()
    {
        return ['price','offices','tables','sqm'];
    }
}
