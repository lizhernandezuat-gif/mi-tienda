<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DetectTelefonoDuplicates extends Command
{
    protected $signature = 'detect:telefono-duplicates';
    protected $description = 'Lista teléfonos duplicados y clientes sin teléfono para ayudar en la migración';

    public function handle()
    {
        $this->info('Buscando teléfonos duplicados...');

        $duplicates = DB::table('clientes')
            ->select('telefono', DB::raw('COUNT(*) as c'))
            ->whereNotNull('telefono')
            ->groupBy('telefono')
            ->having('c', '>', 1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('No se encontraron teléfonos duplicados.');
        } else {
            $this->warn('Teléfonos duplicados detectados:');
            foreach ($duplicates as $d) {
                $this->line("Telefono: {$d->telefono} — {$d->c} registros");
                $rows = DB::table('clientes')->where('telefono', $d->telefono)->get();
                foreach ($rows as $r) {
                    $this->line("  - id: {$r->id}, nombre: {$r->nombre}, email: {$r->email}");
                }
            }
        }

        $nulls = DB::table('clientes')->whereNull('telefono')->get();
        if ($nulls->isEmpty()) {
            $this->info('No hay clientes sin teléfono.');
        } else {
            $this->warn('Clientes sin teléfono:');
            foreach ($nulls as $n) {
                $this->line("  - id: {$n->id}, nombre: {$n->nombre}, email: {$n->email}");
            }
        }

        return 0;
    }
}
