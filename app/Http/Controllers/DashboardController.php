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
        $query =  $query->get();
        foreach($query as $item) {
           $item->month = $this->getMonthNameByNumber($item->month);
        }
        return $query;
    }

    private function getVisitasPorMes() {
        $query = Visita::query();
        $query->select(DB::raw('MONTH(data_realizada) month, COUNT(id) as qtde'));
        $query->groupBy('month');
        $query->whereNotNull('data_realizada');
        $query =  $query->get();
        foreach($query as $item) {
            $item->month = $this->getMonthNameByNumber($item->month);
        }
        return $query;
    }

    private function getTotalVisitas($mes) {
        $query = Visita::query();
        $query->join('status_visitas','status_visitas.id', '=', 'visitas.status_id');
        $query->select(DB::raw('status_visitas.descricao as descricao, COUNT(visitas.id) as qtde'));
        $query->groupBy('status_visitas.descricao');
        $query->orderBy('status_visitas.descricao', );
        $query->whereMonth('created_at', $mes);
        return $query->get();
    }

    public function getDashboardData(Request $request) {
        $data['cestaBasicas'] = $this->getCestasBasicasPorMes();
        $data['visitasPorMes'] = $this->getVisitasPorMes();
        $data['totalVisitas'] = $this->getTotalVisitas($request->month);
        return $data;
    }

    private function getMonthNameByNumber($month) {
        $months = array (1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',
        10=>'Outubro',11=>'Novembro',12=>'Dezembro');
        return $months[(int)$month];
    }
}
