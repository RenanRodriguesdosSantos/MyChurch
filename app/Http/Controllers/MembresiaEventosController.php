<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\MembresiaEventos;
use App\Models\Visita;
use Illuminate\Http\Request;
use App\Models\Evento;

class MembresiaEventosController extends Controller
{

    public function addMembroEvento(Request $request) {
        $this->changeStatusEvento($request->evento_id);
        return MembresiaEventos::create($request->all());
    }

    public function removeMembroEvento(Request $request) {
        $this->changeStatusEvento($request->evento_id);
        return MembresiaEventos::where('membro_id', $request->membro_id)
        ->where('evento_id', $request->evento_id)
        ->delete();
    }

    public function getAllMembrosInEventos(Request $request)
    {
        $membros = Membresia::select('id', 'nome', 'tipo', 'foto')->orderBy('nome', 'asc')->get();
        $membrosPresentes = MembresiaEventos::where('evento_id', $request->evento_id)->select('membro_id')->pluck('membro_id')->toArray();

        $collection = collect();

        foreach($membros as $membro) {
            $item = $membro;
            $item->checked = in_array($membro->id , $membrosPresentes);
            $collection->push($membro);
        }
        return $collection;
    }

    public function changeStatusEvento($evento_id)
    {
        $participantes = MembresiaEventos::where('evento_id', $evento_id)->count();
        $update = $participantes? ["evento_status_id" => 1]:["evento_status_id" => 2];
        Evento::find($evento_id)->update($update);
        
    }

    public function getRelatorioFrequencia(Request $request){
        $dataInicial = $request->inicio;
        $dataFinal = $request->fim;

        $membro = Membresia::find($request->id);
        $visitas = Visita::where("membro_visitado",$request->id)
                            ->where(function ($query) use ($dataInicial,$dataFinal){
                                if(isset($dataInicial)){
                                    if(isset($dataFinal)){
                                        $query->whereBetween("data_realizada",[$dataInicial,date('Ymd', strtotime('+1 day', strtotime($dataFinal)))]);
                                    }else{
                                        $query->whereDate('data_realizada',$dataInicial);
                                    }
                                }
                            })
                          ->where("status_id", '2')
                          ->selectRaw("count(id) as total, sum(qtde_cesta_basicas) as cestas")
                          ->get();

        $eventosMembro = MembresiaEventos::where('membro_id', $request->id)
                                            ->select('evento_id')
                                            ->pluck('evento_id')
                                            ->toArray();
                                            $eventos = Evento::where(function ($query) use ($dataInicial,$dataFinal){
                                                    if(isset($dataInicial)){
                                                        if(isset($dataFinal)){
                                                            $query->whereBetween("data",[$dataInicial,date('Ymd', strtotime('+1 day', strtotime($dataFinal)))]);
                                                        }else{
                                                            $query->whereDate('data',$dataInicial);
                                                        }
                                                    }
                                                })
                                                ->where("evento_status_id",'1')
                                                ->get();

        $collection = collect();

        foreach($eventos as $evento) {
            $evento->presente = in_array($evento->id , $eventosMembro);
            $collection->push($evento);
        }
        return ["membro" => $membro, "eventos" => $collection, "visitas" => $visitas[0]];
    }
}
