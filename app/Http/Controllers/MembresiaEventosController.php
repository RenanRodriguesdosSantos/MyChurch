<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use App\Models\MembresiaEventos;
use Illuminate\Http\Request;

class MembresiaEventosController extends Controller
{

    public function addMembroEvento(Request $request) {
        return MembresiaEventos::create($request->all());
    }

    public function removeMembroEvento(Request $request) {
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
}
