<?php

namespace App\Imports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class ImportBudgets implements ToModel, WithHeadingRow
{
    
    
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    
    
    public function model(array $row)
    {
        return new Budget([
            'businessUnit' => $row['unidad_negocio'],
            'goal' => $row['meta_unidad'],
            'goalPercent' => $row['porcentaje_unidad'],
            'goalDirector' => $row['meta_director'],
            'goalDirectorPercent' => $row['porcentaje_director'],
            'goalCommercial'=> $row['meta_comerciales'],
            'commercialPercent' => $row['porcentaje_comerciales'],
            'q1Percent' => $row['Q1_%'],
            'q2Percent' => $row['Q2_%'],
            'q3Percent' => $row['Q3_%'],
            'q4Percent' => $row['Q4_%'],
            'q1' => $row['Q1_$'],
            'q2' => $row['Q2_$'],
            'q3' => $row['Q3_$'],
            'q4' => $row['Q4_$'],
        ]);
    }
}
