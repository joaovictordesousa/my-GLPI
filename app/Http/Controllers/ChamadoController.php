<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chamado;
use App\Models\Auxprioridade;
use App\Models\MensagemChamado;

class ChamadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consulta = Chamado::with(['tecnico', 'usuario'])->orderBy('id', 'desc');

        if (! auth()->user()->isTecnico()) {
            $consulta->where('usuario_id', auth()->id());
        }

        $AllChamados = $consulta->paginate(15);
        $AllAuxprioridades = Auxprioridade::all();

        return view('dashboard', [
        'AllChamados' => $AllChamados, 
        'AllAuxprioridades' => $AllAuxprioridades
        ]);
    }

    public function chamado()
    {
        abort_if(auth()->user()->isTecnico(), 403);

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
        abort_if(auth()->user()->isTecnico(), 403);

        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'discricao' => ['required', 'string'],
            'prioridade_id' => ['required', 'integer'],
            'anexo' => ['required', 'file', 'max:10240'],
        ]);

        $dados['anexo'] = $request->file('anexo')->store('anexos', 'public');
        $dados['usuario_id'] = auth()->id();

        $cadastro = new Chamado();
        $cadastro->fill($dados);
        $cadastro->save();

        return redirect()->route('dashboard')->with('success', 'Cadastrado com sucesso!');
    }

    public function assumir(Chamado $chamado)
    {
        abort_unless(auth()->user()->isTecnico(), 403);

        $assumido = Chamado::whereKey($chamado->id)
            ->whereNull('tecnico_id')
            ->update([
                'tecnico_id' => auth()->id(),
                'atendido_em' => now(),
                'updated_at' => now(),
            ]);

        if (! $assumido) {
            return back()->with('error', 'Este chamado já foi assumido por outro técnico.');
        }

        return back()->with('success', 'Você assumiu o atendimento deste chamado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chamado = Chamado::with(['usuario', 'tecnico', 'mensagens.usuario'])->findOrFail($id);
        $this->autorizaVisualizacao($chamado);

        return view('chamados.show', [
            'chamado' => $chamado,
            'AllAuxprioridades' => Auxprioridade::all(),
        ]);
    }

    public function responder(Request $request, Chamado $chamado)
    {
        $this->autorizaVisualizacao($chamado);
        abort_if($chamado->status === 'fechado', 422, 'Este chamado já está fechado.');

        $dados = $request->validate([
            'mensagem' => ['nullable', 'string', 'required_without:anexo'],
            'anexo' => ['nullable', 'file', 'max:10240'],
        ]);

        if ($request->hasFile('anexo')) {
            $dados['anexo'] = $request->file('anexo')->store('anexos/mensagens', 'public');
        }

        MensagemChamado::create([
            'chamado_id' => $chamado->id,
            'user_id' => auth()->id(),
            'mensagem' => $dados['mensagem'] ?? null,
            'anexo' => $dados['anexo'] ?? null,
        ]);

        return back()->with('success', 'Resposta enviada.');
    }

    public function atualizar(Request $request, Chamado $chamado)
    {
        abort_unless(auth()->user()->isTecnico(), 403);
        abort_if($chamado->status === 'fechado', 422, 'Este chamado já está fechado.');

        $dados = $request->validate([
            'status' => ['required', 'in:aberto,em_atendimento,resolvido'],
            'prioridade_id' => ['required', 'integer'],
        ]);
        $chamado->update($dados);

        return back()->with('success', 'Status e prioridade atualizados.');
    }

    public function fechar(Chamado $chamado)
    {
        $this->autorizaVisualizacao($chamado);
        abort_if($chamado->status === 'fechado', 422, 'Este chamado já está fechado.');

        $chamado->update([
            'status' => 'fechado',
            'encerrado_por' => auth()->id(),
            'encerrado_em' => now(),
        ]);

        return back()->with('success', 'Chamado fechado.');
    }

    private function autorizaVisualizacao(Chamado $chamado): void
    {
        abort_unless(auth()->user()->isTecnico() || $chamado->usuario_id === auth()->id(), 403);
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
