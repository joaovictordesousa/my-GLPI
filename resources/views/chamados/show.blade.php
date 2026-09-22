@include('cabecalho_rodape.cabecalho')

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Chamado #{{ $chamado->id }} — {{ $chamado->titulo }}</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 row g-4">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-primary">{{ str_replace('_', ' ', $chamado->status) }}</span>
                                <span class="text-muted ms-2">Aberto por {{ $chamado->usuario?->name ?? 'Usuário não identificado' }}</span>
                            </div>
                            @if ($chamado->anexo)
                                <a href="{{ asset('storage/'.$chamado->anexo) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-paperclip"></i> Anexo inicial</a>
                            @endif
                        </div>
                        <p class="mb-0">{{ $chamado->discricao }}</p>
                    </div>
                </div>

                <h5 class="mb-3">Conversa</h5>
                @forelse ($chamado->mensagens as $resposta)
                    <div class="card border-0 shadow-sm mb-3 {{ $resposta->user_id === auth()->id() ? 'bg-light' : '' }}">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between mb-2"><strong>{{ $resposta->usuario->name }}</strong><small class="text-muted">{{ $resposta->created_at->format('d/m/Y H:i') }}</small></div>
                            @if ($resposta->mensagem)<p class="mb-2">{{ $resposta->mensagem }}</p>@endif
                            @if ($resposta->anexo)<a href="{{ asset('storage/'.$resposta->anexo) }}" target="_blank"><i class="bi bi-paperclip"></i> Baixar anexo</a>@endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Ainda não há mensagens neste chamado.</p>
                @endforelse

                @if ($chamado->status !== 'fechado')
                    <div class="card border-0 shadow-sm"><div class="card-body">
                        <form action="{{ route('chamado.responder', $chamado) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-label fw-semibold">Responder</label>
                            <textarea name="mensagem" class="form-control @error('mensagem') is-invalid @enderror" rows="4" placeholder="Escreva sua mensagem..."></textarea>
                            @error('mensagem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="d-flex justify-content-between align-items-center mt-3 gap-2">
                                <input type="file" name="anexo" class="form-control @error('anexo') is-invalid @enderror">
                                <button class="btn btn-primary text-nowrap" type="submit">Enviar resposta</button>
                            </div>
                            @error('anexo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </form>
                    </div></div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h5 class="mb-3">Atendimento</h5>
                    <p><strong>Técnico:</strong> {{ $chamado->tecnico?->name ?? 'Não assumido' }}</p>
                    @if (auth()->user()->isTecnico() && $chamado->status !== 'fechado')
                        <form action="{{ route('chamado.atualizar', $chamado) }}" method="POST" class="mb-3">@csrf @method('PATCH')
                            <label class="form-label">Status</label><select name="status" class="form-select mb-2">@foreach (['aberto' => 'Aberto', 'em_atendimento' => 'Em atendimento', 'resolvido' => 'Resolvido'] as $valor => $rotulo)<option value="{{ $valor }}" @selected($chamado->status === $valor)>{{ $rotulo }}</option>@endforeach</select>
                            <label class="form-label">Prioridade</label><select name="prioridade_id" class="form-select mb-2">@foreach ($AllAuxprioridades as $prioridade)<option value="{{ $prioridade->id }}" @selected($chamado->prioridade_id == $prioridade->id)>{{ $prioridade->status }}</option>@endforeach</select>
                            <button class="btn btn-outline-primary w-100">Atualizar</button>
                        </form>
                    @endif
                    @if ($chamado->status !== 'fechado')
                        <form action="{{ route('chamado.fechar', $chamado) }}" method="POST">@csrf<button class="btn btn-danger w-100">Fechar chamado</button></form>
                    @else
                        <span class="badge bg-secondary">Fechado em {{ $chamado->encerrado_em?->format('d/m/Y H:i') }}</span>
                    @endif
                </div></div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('cabecalho_rodape.rodape')
