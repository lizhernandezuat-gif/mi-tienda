<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitasExport implements FromCollection, WithHeadings, WithMapping
{
    protected $citas;

    // Recibimos las citas filtradas desde el controlador
    public function __construct($citas)
    {
        $this->citas = $citas;
    }

    public function collection()
    {
        return $this->citas;
    }

    // 1. Aquí definimos los títulos de las columnas
    public function headings(): array
    {
        return [
            'Fecha',
            'Hora',
            'Cliente',
            'Teléfono',
            'Mascotas',
            'Motivo',
            'Estado'
        ];
    }

    // 2. Aquí mapeamos los datos de cada cita a su columna
    public function map($cita): array
    {
        // Unimos los nombres de las mascotas con una coma (ej: Firulais, Michi)
        $mascotas = $cita->mascotas->pluck('nombre')->implode(', ');

        return [
            $cita->fecha_hora_inicio->format('d/m/Y'),
            $cita->fecha_hora_inicio->format('H:i'),
            $cita->cliente->nombre,
            $cita->cliente->telefono,
            $mascotas,
            $cita->motivo,
            strtoupper($cita->estado),
        ];
    }
}