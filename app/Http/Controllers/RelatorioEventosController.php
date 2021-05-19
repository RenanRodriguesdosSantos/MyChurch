<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Models\Membresia;
use Response;

class RelatorioEventosController extends Controller
{

    public function getRelatorioEventosData(Request $request)
    {
        $return = new class{};
        $eventos = Evento::with('participantes')->where('evento_status_id', 1)->get(); //eventos realizados

        if($request->inicio)
            $eventos = $eventos->where('data', '>=',$request->inicio);

        if($request->fim)
            $eventos = $eventos->where('data', '<=',$request->fim);

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
            $return->frequencia_media = round($eventos_collect->sum('participantes_membros') / $eventos_collect->sum('total_membros') * 100, 2);
        }
        return Response::json($return);
    }

    public function getTotalMembrosEvento($evento_id, $tipo=null)
    {
        $membros_evento = Membresia::where('created_at', '<=', Evento::find($evento_id)->data);

        if($tipo)
            $membros_evento = $membros_evento->where('tipo', $tipo);

        return $membros_evento->count();
    }
}
