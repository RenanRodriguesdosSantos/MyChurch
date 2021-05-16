<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    private function getCestasBasicasPorMes() {
        $query = Visita::query();
        $query->select(DB::raw('MONTH(data_realizada) month, SUM(qtde_cesta_basicas) as qtde'));
        $query->groupBy('month');
        $query->whereNotNull('data_realizada');
        return $query->get();
    }

    private function getVisitasPorMes() {
        $query = Visita::query();
        $query->select(DB::raw('MONTH(data_realizada) month, COUNT(id) as qtde'));
        $query->groupBy('month');
        return $query->get();
    }

    private function getTotalVisitas($mes) {
        $query = Visita::query();
        $query->join('status_visitas','status_visitas.id', '=', 'visitas.status_id');
        $query->select(DB::raw('status_visitas.descricao as descricao, COUNT(visitas.id) as qtde'));
        $query->groupBy('status_visitas.descricao');
        $query->whereMonth('data_realizada', $mes);
        return $query->get();
    }

    public function getDashboardData(Request $request) {
        $data['cestaBasicas'] = $this->getCestasBasicasPorMes();
        $data['visitasPorMes'] = $this->getVisitasPorMes();
        $data['totalVisitas'] = $this->getTotalVisitas($request->month);
        return $data;
    }
}
