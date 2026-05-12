<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top" x-data="{ open: false }">
    <div class="container-fluid max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('img/Logo_JvS.png') }}" alt="Logo" width="100" height="100" class="d-inline-block align-text-top">
            <span class="ms-2 fw-semibold text-primary d-none d-sm-inline">Sistema de Chamados</span>
        </a>

        <!-- Botão Toggle para mobile -->
        <button class="navbar-toggler border-0" type="button" @click="open = !open" :aria-expanded="open" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Collapsível -->
        <div class="collapse navbar-collapse" :class="{'show': open}" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i>
                        {{ __('Dashboard') }}
                    </a>
                </li>
                
                <!-- Links adicionais podem ser adicionados aqui -->
                @if(Auth::user() && Auth::user()->email == 'admin@example.com')
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-gear me-1"></i>
                        Admin
                    </a>
                </li>
                @endif
            </ul>

            <!-- Dropdown do Usuário (Desktop) -->
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" 
                        type="button" 
                        id="userDropdown" 
                        data-bs-toggle="dropdown" 
                        aria-expanded="false">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-1">
                        <i class="bi bi-person-circle text-primary"></i>
                    </div>
                    <span class="fw-medium">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-badge"></i>
                            {{ __('Profile') }}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Menu Mobile -->
            <div class="d-lg-none mt-3 pt-3 border-top">
                <!-- Informações do usuário -->
                <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                        <i class="bi bi-person-circle fs-4 text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                </div>
                
                <!-- Links mobile -->
                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-badge me-2"></i>
                    {{ __('Profile') }}
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Estilos do Navbar */
    .navbar {
        transition: all 0.3s ease;
    }
    
    .navbar-brand {
        transition: transform 0.2s ease;
    }
    
    .navbar-brand:hover {
        transform: scale(1.02);
    }
    
    .nav-link {
        position: relative;
        color: #6c757d !important;
        transition: all 0.2s ease;
        padding: 0.5rem 1rem !important;
        margin: 0 0.25rem;
        border-radius: 0.5rem;
    }
    
    .nav-link:hover {
        color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.08);
    }
    
    .nav-link.active {
        color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.12);
    }
    
    .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background-color: #0d6efd;
        border-radius: 3px 3px 0 0;
    }
    
    /* Dropdown estilizado */
    .dropdown-menu {
        border-radius: 0.75rem;
        animation: fadeInDown 0.2s ease;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .dropdown-item {
        padding: 0.6rem 1.2rem;
        transition: all 0.2s ease;
        border-radius: 0.5rem;
        margin: 0.2rem 0.5rem;
    }
    
    .dropdown-item:hover {
        background-color: rgba(13, 110, 253, 0.08);
        transform: translateX(5px);
    }
    
    /* Botão do usuário */
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 2rem;
        padding: 0.4rem 1rem;
        transition: all 0.2s ease;
    }
    
    .btn-light:hover {
        background-color: #fff;
        border-color: #0d6efd;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    /* Toggle button customizado */
    .navbar-toggler {
        transition: all 0.2s ease;
    }
    
    .navbar-toggler:hover {
        background-color: rgba(13, 110, 253, 0.08);
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .navbar-collapse {
            padding: 1rem 0;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .nav-link.active::after {
            display: none;
        }
        
        .nav-link.active {
            background-color: rgba(13, 110, 253, 0.12);
        }
    }
    
    /* Scrollbar personalizada para mobile */
    .navbar-collapse::-webkit-scrollbar {
        width: 4px;
    }
    
    .navbar-collapse::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .navbar-collapse::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    /* Badge de notificações (opcional) */
    .notification-badge {
        position: relative;
    }
    
    .notification-badge::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 8px;
        height: 8px;
        background-color: #dc3545;
        border-radius: 50%;
        border: 2px solid white;
    }
</style>

<!-- Script para controle do Bootstrap Collapse com Alpine.js -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sincroniza o Bootstrap collapse com o Alpine.js
        const toggler = document.querySelector('.navbar-toggler');
        const collapse = document.querySelector('.navbar-collapse');
        
        if (toggler && collapse) {
            toggler.addEventListener('click', function() {
                // O Alpine.js já gerencia o estado 'open'
                // Isso é apenas para garantir compatibilidade
                setTimeout(() => {
                    if (collapse.classList.contains('show')) {
                        window.dispatchEvent(new Event('resize'));
                    }
                }, 300);
            });
        }
        
        // Fecha o menu ao clicar em um link (mobile)
        const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');
        const navbarCollapse = document.querySelector('.navbar-collapse');
        
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                    // Dispara o clique no toggler para fechar
                    const togglerBtn = document.querySelector('.navbar-toggler');
                    if (togglerBtn) togglerBtn.click();
                }
            });
        });
    });
</script>