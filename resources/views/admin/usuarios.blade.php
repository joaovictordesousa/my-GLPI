@include('cabecalho_rodape.cabecalho')

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="bi bi-people me-2"></i>Gerenciar usuários</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </x-slot>

    <div class="py-5"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        <div class="card border-0 shadow-sm mb-4"><div class="card-body">
            <h5 class="mb-3">Adicionar usuário</h5>
            <form action="{{ route('admin.usuarios.store') }}" method="POST" class="row g-3">@csrf
                <div class="col-md-4"><label class="form-label">Nome</label><input name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-4"><label class="form-label">E-mail</label><input name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-2"><label class="form-label">Senha</label><input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="col-md-2"><label class="form-label">Confirmar senha</label><input name="password_confirmation" type="password" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label">Nível</label><select name="tipo" class="form-select"><option value="usuario">Usuário</option><option value="tecnico">Técnico</option><option value="administrador">Administrador</option></select></div>
                <div class="col-md-3"><label class="form-label">Status</label><select name="ativo" class="form-select"><option value="1">Ativo</option><option value="0">Desativado</option></select></div>
                <div class="col-md-6 d-flex align-items-end"><button class="btn btn-success"><i class="bi bi-person-plus"></i> Criar usuário</button></div>
            </form>
        </div></div>
        <div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table align-middle mb-0">
            <thead class="table-light"><tr><th>Nome</th><th>E-mail</th><th>Nível</th><th>Status</th><th class="text-end">Ação</th></tr></thead>
            <tbody>@foreach($usuarios as $usuario)
                <tr><td class="fw-semibold">{{ $usuario->name }} @if($usuario->is(auth()->user()))<small class="text-muted">(você)</small>@endif</td><td>{{ $usuario->email }}</td>
                    <td colspan="3"><form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="d-flex justify-content-end gap-2">@csrf @method('PATCH')
                        <select name="tipo" class="form-select form-select-sm" style="max-width: 165px;">@foreach(['usuario'=>'Usuário', 'tecnico'=>'Técnico', 'administrador'=>'Administrador'] as $valor=>$texto)<option value="{{ $valor }}" @selected($usuario->tipo === $valor)>{{ $texto }}</option>@endforeach</select>
                        <select name="ativo" class="form-select form-select-sm" style="max-width: 130px;"><option value="1" @selected($usuario->ativo)>Ativo</option><option value="0" @selected(! $usuario->ativo)>Desativado</option></select>
                        <button class="btn btn-sm btn-primary">Salvar</button>
                    </form></td>
                </tr>
            @endforeach</tbody>
        </table></div></div>
        <div class="mt-3">{{ $usuarios->links() }}</div>
    </div></div>
</x-app-layout>

@include('cabecalho_rodape.rodape')
