<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Membresia;
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
        $data['relatorioEventos'] = $this->getRelatorioEventoTop5();
        return $data;
    }

    private function getMonthNameByNumber($month) {
        $months = array (1=>'Janeiro',2=>'Fevereiro',3=>'Março',4=>'Abril',5=>'Maio',6=>'Junho',7=>'Julho',8=>'Agosto',9=>'Setembro',
        10=>'Outubro',11=>'Novembro',12=>'Dezembro');
        return $months[(int)$month];
    }

    public function getRelatorioEventoTop5()
    {
        $return = new class{};
        $eventos = Evento::with('participantes')->where('evento_status_id', 1)->orderBy('data', 'DESC')->get()->take(5); //eventos realizados

        if($eventos->isNotEmpty()){
            $eventos_collect = collect();
            foreach ($eventos as $evento) {
                $obj_evento = new class{};
                $obj_evento->descricao = $evento->nome;
                $obj_evento->data = date( 'd/m/Y', strtotime($evento->data));
                $obj_evento->hora = date( 'H:i', strtotime($evento->data));
                $obj_evento->participantes = $evento->participantes->count();
                $obj_evento->participantes_membros = $evento->participantes->where('membro.tipo', 1)->count();
                $obj_evento->participantes_visitantes = $evento->participantes->where('membro.tipo', 2)->count();
                $obj_evento->total_membros = $this->getTotalMembrosEvento($evento->id, 1);
                $obj_evento->frequencia = $obj_evento->participantes_membros / $obj_evento->total_membros * 100;

                $eventos_collect->push($obj_evento);
            }
            $return->eventos = $eventos_collect->sortBy('data')->values();
            $return->frequencia_media = $eventos_collect->sum('participantes_membros') / $eventos_collect->sum('total_membros') * 100;
        }
        return $return;
    }
    public function getTotalMembrosEvento($evento_id, $tipo=null)
    {
        $membros_evento = Membresia::whereDate('created_at', '<=', Evento::find($evento_id)->data);

        if($tipo)
            $membros_evento = $membros_evento->where('tipo', $tipo);

        return $membros_evento->count();
    }
}
