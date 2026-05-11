@include('cabecalho_rodape.cabecalho')

@if (session('success'))
    <div class="alert alert-primary">
        {{ session('success') }}
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('.alert-primary').style.display = 'none';
        }, {{ session('display_time', 5000) }});
    </script>
@endif


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Prioridade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $AllChamados as $chamado )                        
                            <tr>
                                <td>{{ $chamado->id }}</td>
                                <td>{{ $chamado->titulo }}</td>
                                <td>{{ $chamado->discricao }}</td>
                                <td>{{ $chamado->prioridade_id }}</td>
                            </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('cabecalho_rodape.rodape')