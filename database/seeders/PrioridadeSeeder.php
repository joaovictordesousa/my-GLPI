<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Auxprioridade;
use Illuminate\Database\Seeder;

class PrioridadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prioridades = [
            ['status' => 'Baixa'],
            ['status' => 'Média'],
            ['status' => 'Alta'],
            ['status' => 'Urgente'],
        ];

        foreach ($prioridades as $prioridade) {
            Auxprioridade::updateOrCreate(
                ['status' => $prioridade['status']],
                $prioridade
            );
        }
    }
}
