<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BudgetsTemplateExport implements FromView, WithHeadings, WithTitle, ShouldAutoSize
{
    public function view(): View
    {
        return view('exports.budgetsTemplate');
    }

    public function headings(): array
    {
        return [
            'unidad_negocio',
            'meta_unidad',
            'porcentaje_unidad',
            'meta_director',
            'porcentaje_director',
            'meta_comerciales',
            'porcentaje_comerciales',
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

    public function title(): string
    {
        return 'template Presupuesto Meltec';
    }
}
