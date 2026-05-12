<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado;
use App\Models\Auxprioridade;

class ChamadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $AllChamados = Chamado::orderBy('id', 'desc')->paginate(15);
        $AllAuxprioridades = Auxprioridade::all();

        return view('dashboard', [
        'AllChamados' => $AllChamados, 
        'AllAuxprioridades' => $AllAuxprioridades
        ]);
    }

    public function chamado()
    {
        $AllAuxprioridades = Auxprioridade::all();

        return view('chamado', ['AllAuxprioridades' => $AllAuxprioridades]);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $cadastro = new Chamado();
        $cadastro->fill($request->all());
        $cadastro->save();

        return redirect()->route('dashboard')->with('success', 'Cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
