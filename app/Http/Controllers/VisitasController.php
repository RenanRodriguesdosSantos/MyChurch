<?php

namespace App\Http\Controllers;

use App\Models\StatusVisitas;
use App\Models\Visita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Visita::with('criadoPor','responsavel','status')
        ->where('status_id',StatusVisitas::where('slug','agendada')->first()->id)
        ->get();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id)
            Visita::find($request->id)->update([
                'criado_por' => Auth::user()->id,
                'data_visita' => $request->data_visita,
                'endereco' => $request->endereco,
                'descricao' => $request->descricao,
            ]);
        else
        Visita::create([
            'criado_por' => Auth::user()->id,
            'data_visita' => $request->data_visita,
            'endereco' => $request->endereco,
            'descricao' => $request->descricao,
            'status_id' => StatusVisitas::where('slug','agendada')->first()->id
        ]);
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Visita::with('criadoPor')->find($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Visita::find($request->id)->delete();
    }

    public function finalizar(Request $request){
        Visita::find($request->id)->update([
            'responsavel' => Auth::user()->id,
            'observacao' => $request->observacao,
            'status_id' => StatusVisitas::where('slug','realizada')->first()->id,
            'data_realizada' => date('yyyy-mm-dd')
        ]);
    }
}
