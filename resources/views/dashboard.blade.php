@include('cabecalho_rodape.cabecalho')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow-lg"
        role="alert"
        style="z-index: 1050; min-width: 350px; backdrop-filter: blur(10px); background-color: rgba(25, 135, 84, 0.95);">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <script>
        setTimeout(function () {
            let alert = document.querySelector('.alert-success');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, {{ session('display_time', 5000) }});
    </script>
@endif

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-none d-sm-block">
                    <i class="bi bi-grid-1x2-fill fs-4 text-primary"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                        {{ __('Dashboard') }}
                    </h2>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.chamado') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg"></i> Novo Chamado
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cards de estatísticas -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total de Chamados</h6>
                                    <h3 class="mb-0">{{ count($AllChamados) }}</h3>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-ticket-detailed fs-4 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Prioridade Alta</h6>
                                    <h3 class="mb-0 text-danger">
                                        {{ $AllChamados->where('prioridade_id', 3)->count() }}
                                    </h3>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                    <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Prioridade Urgente</h6>
                                    <h3 class="mb-0 text-dark">
                                        {{ $AllChamados->where('prioridade_id', 4)->count() }}
                                    </h3>
                                </div>
                                <div class="rounded-circle bg-dark bg-opacity-10 p-3">
                                    <i class="bi bi-alarm fs-4 text-dark"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Prioridade Média</h6>
                                    <h3 class="mb-0 text-warning">
                                        {{ $AllChamados->where('prioridade_id', 2)->count() }}
                                    </h3>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="bi bi-arrow-up-circle fs-4 text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card principal da tabela -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="mb-0">
                                <i class="bi bi-table me-2 text-primary"></i>
                                Lista de Chamados
                            </h5>
                            <p class="text-muted small mb-0 mt-1">
                                <i class="bi bi-info-circle"></i> Clique em qualquer linha para ver detalhes
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <!-- Campo de busca -->
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0"
                                    placeholder="Filtrar chamados...">
                            </div>
                            <!-- Filtro por prioridade -->
                            <select id="priorityFilter" class="form-select form-select-sm" style="width: 130px;">
                                <option value="all">Todas</option>
                                <option value="1">Baixa</option>
                                <option value="2">Média</option>
                                <option value="3">Alta</option>
                                <option value="4">Urgente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="chamadosTable">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" width="5%" class="ps-4">ID</th>
                                    <th scope="col" width="20%">
                                        <i class="bi bi-card-heading me-1"></i> Título
                                    </th>
                                    <th scope="col" width="50%">
                                        <i class="bi bi-text-paragraph me-1"></i> Descrição
                                    </th>
                                    <th scope="col" width="15%">
                                        <i class="bi bi-flag me-1"></i> Prioridade
                                    </th>
                                    <th scope="col" width="10%" class="text-center">
                                        <i class="bi bi-three-dots"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($AllChamados as $chamado)
                                    <tr class="chamado-row" data-prioridade="{{ $chamado->prioridade_id }}">
                                        <td class="ps-4">
                                            <span
                                                class="badge bg-secondary bg-opacity-10 text-secondary">#{{ $chamado->id }}</span>
                                        </td>
                                        <td class="fw-semibold">{{ $chamado->titulo }}</td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 400px;"
                                                title="{{ $chamado->discricao }}">
                                                {{ $chamado->discricao }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $prioridadeConfig = [
                                                    3 => ['label' => 'Baixa', 'class' => 'success', 'icon' => 'bi-arrow-down-circle'],
                                                    2 => ['label' => 'Média', 'class' => 'warning', 'icon' => 'bi-arrow-right-circle'],
                                                    1 => ['label' => 'Alta', 'class' => 'danger', 'icon' => 'bi-arrow-up-circle'],
                                                    4 => ['label' => 'Urgente', 'class' => 'dark', 'icon' => 'bi-exclamation-octagon'],
                                                ];
                                                $config = $prioridadeConfig[$chamado->prioridade_id] ?? ['label' => 'Não definida', 'class' => 'secondary', 'icon' => 'bi-question-circle'];
                                            @endphp
                                            <span
                                                class="badge bg-{{ $config['class'] }} bg-opacity-10 text-{{ $config['class'] }} px-3 py-2">
                                                <i class="bi {{ $config['icon'] }} me-1"></i>
                                                {{ $config['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-link text-primary p-0 view-details"
                                                data-id="{{ $chamado->id }}" data-titulo="{{ $chamado->titulo }}"
                                                data-descricao="{{ $chamado->discricao }}"
                                                data-prioridade="{{ $config['label'] }}">
                                                <i class="bi bi-eye fs-6"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                            <h6 class="text-muted">Nenhum chamado encontrado</h6>
                                            <button class="btn btn-sm btn-primary mt-2">
                                                <i class="bi bi-plus-lg"></i> Criar primeiro chamado
                                            </button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="container_paginator">
                        {{ $AllChamados->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('cabecalho_rodape.rodape')

<!-- Modal para visualizar detalhes -->
<div class="modal fade" id="chamadoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-ticket-detailed me-2"></i>
                    Detalhes do Chamado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label text-muted small">Título</label>
                    <h6 id="modalTitulo" class="fw-semibold"></h6>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small">Descrição</label>
                    <p id="modalDescricao" class="mb-0"></p>
                </div>
                <div>
                    <label class="form-label text-muted small">Prioridade</label>
                    <div>
                        <span id="modalPrioridade" class="badge"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Editar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para filtros e interatividade -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Filtro por texto e prioridade
        const searchInput = document.getElementById('searchInput');
        const priorityFilter = document.getElementById('priorityFilter');
        const tableRows = document.querySelectorAll('.chamado-row');
        const showingSpan = document.getElementById('showingCount');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const priorityValue = priorityFilter.value;
            let visibleCount = 0;

            tableRows.forEach(row => {
                const titulo = row.cells[1]?.textContent.toLowerCase() || '';
                const descricao = row.cells[2]?.textContent.toLowerCase() || '';
                const prioridade = row.getAttribute('data-prioridade');

                const matchesSearch = titulo.includes(searchTerm) || descricao.includes(searchTerm);
                const matchesPriority = priorityValue === 'all' || prioridade === priorityValue;

                if (matchesSearch && matchesPriority) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (showingSpan) {
                showingSpan.textContent = visibleCount;
            }
        }

        if (searchInput) searchInput.addEventListener('keyup', filterTable);
        if (priorityFilter) priorityFilter.addEventListener('change', filterTable);

        // Modal de detalhes
        const modal = new bootstrap.Modal(document.getElementById('chamadoModal'));
        const viewButtons = document.querySelectorAll('.view-details');

        viewButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const titulo = this.getAttribute('data-titulo');
                const descricao = this.getAttribute('data-descricao');
                const prioridade = this.getAttribute('data-prioridade');

                document.getElementById('modalTitulo').textContent = titulo;
                document.getElementById('modalDescricao').textContent = descricao;

                const prioridadeBadge = document.getElementById('modalPrioridade');
                prioridadeBadge.textContent = prioridade;

                // Ajustar cor do badge no modal
                const prioridadeMap = {
                    'Baixa': 'success',
                    'Média': 'warning',
                    'Alta': 'danger',
                    'Urgente': 'dark'
                };
                const cor = prioridadeMap[prioridade] || 'secondary';
                prioridadeBadge.className = `badge bg-${cor}`;

                modal.show();
            });
        });
    });
</script>

<!-- Bootstrap Icons e CSS adicional -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">