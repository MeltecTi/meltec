<?php

namespace App\Exports;

use App\Models\Budget;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithTitle;
use NumberFormatter;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;

class ExportBudgets implements FromView, WithHeadings, WithMapping, WithValidation, WithTitle, ShouldAutoSize
{

    public function view(): View
    {
        $budgets = Budget::all();

        return view('exports.budgets', [
            'budgets' => $budgets,
        ]);
    }

    public function headings(): array
    {
        return [
            'Unidad Negocio',
            'Meta Unidad',
            'Porcentaje Unidad',
            'Meta_Director',
            'Porcentaje Director',
            'Meta Comerciales',
            'Porcentaje_Comerciales',
            'Q1_%',
            'Q2_%',
            'Q3_%',
            'Q4_%',
            'Q1_$',
            'Q2_$',
            'Q3_$',
            'Q4_$',
        ];
    }

    public function map($budget): array
    {
        return [
            $budget->businessUnit,
            $this->formatCurrency($budget->goal),
            $budget->goalPercent,
            $budget->goalDirector,
            $budget->goalDirectorPercent,
            $budget->goalCommercial,
            $budget->commercialPercent,
            $budget->q1Percent,
            $budget->q2Percent,
            $budget->q3Percent,
            $budget->q4Percent,
            $this->formatCurrency($budget->q1),
            $this->formatCurrency($budget->q2),
            $this->formatCurrency($budget->q3),
            $this->formatCurrency($budget->q4),
        ];
    }


    public function formatCurrency($value)
    {
        $formatter = new NumberFormat('en_US', NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($value, 'USD');
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

    public function title(): string
    {
        return 'Presupuestos Meltec ' . date('Y');
    }
}
