@include('cabecalho_rodape.cabecalho')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chamado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('chamado.store') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="validationDefault01" name="titulo" required>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="validationDefault01" name="discricao" required>
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault04" class="form-label">Prioridade</label>
                            <select class="form-select" id="validationDefault04" name="prioridade_id" required>
                                <option selected disabled value="">Selecione...</option>
                                @foreach($AllAuxprioridades as $auxprioridade)
                                    <option value="{{ $auxprioridade->id }}">{{ $auxprioridade->status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="validationDefault01" class="form-label">Anexo</label>
                            <input type="text" class="form-control" id="validationDefault01" name="anexo" required>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-success" type="submit">Abrir chamado</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('cabecalho_rodape.rodape')