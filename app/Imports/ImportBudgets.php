<?php

namespace App\Imports;

use App\Models\Budget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

HeadingRowFormatter::default('none');
class ImportBudgets implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use Importable;

    private $validatedData = [];
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
            'goalCommercial' => $row['meta_comerciales'],
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

    public function getValidatedData()
    {
        return $this->validatedData;
    }

    public function rules(): array
    {
        return [
            '*.unidad_negocio' => 'required',
            '*.meta_unidad' => 'required',
            '*.porcentaje_unidad' => 'required',
            '*.meta_director' => 'required',
            '*.meta_comerciales' => 'required',
            '*.porcentaje_comerciales' => 'required',
            '*.Q1_%' => 'required',
            '*.Q2_%' => 'required',
            '*.Q3_%' => 'required',
            '*.Q4_%' => 'required',
            '*.Q1_$' => 'required',
            '*.Q2_$' => 'required',
            '*.Q3_$' => 'required',
            '*.Q4_$' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.unidad_negocio.required' => 'El campo es Requerido',
            '*.meta_unidad.required' => 'El campo es Requerido',
            '*.porcentaje_unidad.required' => 'El campo es Requerido',
            '*.meta_director.required' => 'El campo es Requerido',
            '*.meta_comerciales.required' => 'El campo es Requerido',
            '*.porcentaje_comerciales.required' => 'El campo es Requerido',
            '*.Q1_%.required' => 'El campo es Requerido',
            '*.Q2_%.required' => 'El campo es Requerido',
            '*.Q3_%.required' => 'El campo es Requerido',
            '*.Q4_%.required' => 'El campo es Requerido',
            '*.Q1_$.required' => 'El campo es Requerido',
            '*.Q2_$.required' => 'El campo es Requerido',
            '*.Q3_$.required' => 'El campo es Requerido',
            '*.Q4_$.required' => 'El campo es Requerido',
        ];
    }
}
