@include('cabecalho_rodape.cabecalho')

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-none d-sm-block">
                    <i class="bi bi-grid-1x2-fill fs-4 text-primary"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-0">
                        {{ __('Criar chamado') }}
                    </h2>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye-fill"></i> Ver chamados abertos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card de instruções -->
            <div class="alert alert-primary alert-dismissible fade show mb-4 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        <strong class="me-2">Instruções:</strong>
                        Preencha todos os campos obrigatórios para abrir um novo chamado.
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                        aria-label="Fechar"></button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Cabeçalho do formulário -->
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-ticket-perforated fs-4 text-success"></i>
                        </div>
                        <div>
                            <h4 class="mb-0">Abrir Novo Chamado</h4>
                            <p class="text-muted small mb-0">Preencha as informações abaixo para registrar sua
                                solicitação</p>
                        </div>
                    </div>

                    <form action="{{ route('chamado.store') }}" method="POST" class="row g-4">
                        @csrf

                        <!-- Título -->
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label fw-semibold">
                                <i class="bi bi-card-heading me-1 text-primary"></i>
                                Título <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-lg @error('titulo') is-invalid @enderror"
                                id="validationDefault01" name="titulo" required
                                placeholder="Digite um título descritivo">
                            <div class="form-text">
                                <i class="bi bi-lightbulb"></i> Ex: Problema no sistema de login
                            </div>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Anexo -->
                        <div class="col-md-6">
                            <label for="validationDefault01" class="form-label fw-semibold">
                                <i class="bi bi-paperclip me-1 text-primary"></i>
                                Anexo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg @error('anexo') is-invalid @enderror"
                                id="validationDefault01" name="anexo" required placeholder="Link ou caminho do anexo">
                            <div class="form-text">
                                <i class="bi bi-link45deg"></i> Informe URL ou caminho do arquivo
                            </div>
                            @error('anexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descrição (campo expandido) -->
                        <div class="col-12">
                            <label for="validationDefault01" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph me-1 text-primary"></i>
                                Descrição <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('discricao') is-invalid @enderror"
                                id="validationDefault01" name="discricao" rows="4" required
                                placeholder="Descreva detalhadamente o problema ou solicitação..."></textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Seja específico para um atendimento mais rápido
                            </div>
                            @error('discricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Prioridade -->
                        <div class="col-md-4">
                            <label for="validationDefault04" class="form-label fw-semibold">
                                <i class="bi bi-flag me-1 text-primary"></i>
                                Prioridade <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('prioridade_id') is-invalid @enderror"
                                id="validationDefault04" name="prioridade_id" required>
                                <option selected disabled value="">Selecione a prioridade...</option>
                                @foreach($AllAuxprioridades as $auxprioridade)
                                    <option value="{{ $auxprioridade->id }}" @if(old('prioridade_id') == $auxprioridade->id)
                                    selected @endif>
                                        @php
                                            $prioridadeIcon = [
                                                3 => '🟢',  // Baixa
                                                2 => '🟡',  // Média
                                                1 => '🔴',  // Alta
                                                4 => '⚫',  // Urgente
                                            ];
                                            $icon = $prioridadeIcon[$auxprioridade->id] ?? '📌';
                                        @endphp
                                        {{ $icon }} {{ $auxprioridade->status }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span class="text-success">Baixa</span> •
                                <span class="text-warning">Média</span> •
                                <span class="text-danger">Alta</span> •
                                <span class="text-dark">Urgente</span>
                            </div>
                            @error('prioridade_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões de ação -->
                        <div class="col-12 mt-4 pt-3 border-top">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-4">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </a>
                                <button class="btn btn-success btn-lg px-5" type="submit">
                                    <i class="bi bi-check-circle me-2"></i> Abrir chamado
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cards informativos -->
            <div class="row mt-4 g-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-light shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-2">
                                    <i class="bi bi-clock text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tempo médio de resposta</small>
                                    <strong>Até 24h úteis</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-light shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-2 me-2">
                                    <i class="bi bi-chat-dots text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Acompanhamento</small>
                                    <strong>Por e-mail e dashboard</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 bg-light shadow-sm h-100">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-2 me-2">
                                    <i class="bi bi-shield-check text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Segurança</small>
                                    <strong>Dados criptografados</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('cabecalho_rodape.rodape')

<!-- Script para manter dados antigos em caso de erro de validação -->
@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Rola suavemente para o primeiro erro
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        });
    </script>
@endif