<!-- Navigation -->
<nav class="p-4 space-y-2">
    @php
        $userRole = Auth::user()->rol ?? 'usuario_general';
    @endphp
    

    @if($userRole === 'usuario_general')
        <!-- Dashboard Principal - Solo Usuario General -->
        <div class="menu-item">
            <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-tachometer-alt text-primary-600"></i>
                <span class="text-sm">Dashboard Principal</span>
            </a>
        </div>

        <!-- Accidentes - Solo Usuario General puede registrar -->
        <div class="menu-item">
            <button onclick="toggleMenu('accidentes')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-shield-alt text-red-600"></i>
                    <span class="text-sm">Accidentes</span>
                </div>
                <i id="accidentes-icon" class="fas fa-chevron-down text-xs"></i>
            </button>
            <div id="accidentes-menu" class="ml-6 mt-1 space-y-1">
                <a href="{{ route('accidentes.create') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Registrar Accidente</a>
                <a href="{{ route('accidentes.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Ver Accidentes</a>
                <a href="{{ route('derivaciones.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Derivaciones</a>
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Solicitar Reintegros</a>
            </div>
        </div>
    @endif


    @if($userRole === 'usuario_general')
        <!-- Alumnos - Solo Usuario General -->
        <div class="menu-item">
            <a href="{{ route('alumnos.index') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('alumnos.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-graduation-cap text-primary-600"></i>
                <span class="text-sm">Alumnos</span>
            </a>
        </div>

        <!-- Salidas Educativas - Solo Usuario General -->
        <div class="menu-item">
            <a href="{{ route('salidas_educativas.index') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('salidas_educativas.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-route text-primary-700"></i>
                <span class="text-sm">Salidas Educativas</span>
            </a>
        </div>

        <!-- Pasantías - Solo Usuario General -->
        <div class="menu-item">
            <a href="{{ route('pasantias.index') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('pasantias.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-building text-primary-800"></i>
                <span class="text-sm">Pasantías</span>
            </a>
        </div>

        <!-- Personal - Solo Usuario General -->
        <div class="menu-item">
            <button onclick="toggleMenu('personal')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-id-badge text-primary-500"></i>
                    <span class="text-sm">Personal</span>
                </div>
                <i id="personal-icon" class="fas fa-chevron-right text-xs"></i>
            </button>
            <div id="personal-menu" class="ml-6 mt-1 space-y-1 hidden">
                <a href="{{ route('empleados.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Empleados</a>
                <a href="{{ route('beneficiarios_svo.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Beneficiarios SVO</a>
            </div>
        </div>

        <!-- Documentos - Solo Usuario General (Modificado para ir directo al index) -->
        <div class="menu-item">
            <a href="{{ route('documentos.index') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('documentos.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-folder-open text-gray-700"></i>
                <span class="text-sm">Documentos</span>
            </a>
        </div>
    @endif

    @if($userRole === 'admin')
        <!-- Dashboard General - Solo Admin -->
        <div class="menu-item">
            <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <i class="fas fa-tachometer-alt text-primary-600"></i>
                <span class="text-sm">Dashboard General</span>
            </a>
        </div>

        <!-- Administración - Solo Admin -->
        <div class="menu-item">
            <button onclick="toggleMenu('administracion')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-cogs text-blue-600"></i>
                    <span class="text-sm">Administración</span>
                </div>
                <i id="administracion-icon" class="fas fa-chevron-right text-xs"></i>
            </button>
            <div id="administracion-menu" class="ml-6 mt-1 space-y-1 hidden">
                <a href="{{ route('escuelas.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Escuelas</a>
                <a href="{{ route('alumnos.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Alumnos</a>
                <a href="{{ route('empleados.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Empleados</a>
                <a href="{{ route('salidas_educativas.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Salidas Educativas</a>
                <a href="{{ route('pasantias.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Pasantías</a>
                <a href="{{ route('beneficiarios_svo.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Beneficiarios SVO</a>
                <a href="{{ route('derivaciones.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors {{ request()->routeIs('derivaciones.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Derivaciones</a>
                <a href="{{ route('documentos.index') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Documentos</a>
            </div>
        </div>

        <!-- Gestión - Solo Admin -->
        <div class="menu-item">
            <button onclick="toggleMenu('gestion')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-tasks text-green-600"></i>
                    <span class="text-sm">Gestión</span>
                </div>
                <i id="gestion-icon" class="fas fa-chevron-right text-xs"></i>
            </button>
            <div id="gestion-menu" class="ml-6 mt-1 space-y-1 hidden">
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Accidentes</a>
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Reintegros</a>
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Gestión de Pagos</a>
            </div>
        </div>

        <!-- Usuarios - Solo Admin -->
        <div class="menu-item">
            <a href="{{ route('usuarios.index') }}" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors {{ request()->routeIs('usuarios.*') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">
                <i class="fas fa-users-cog text-purple-600"></i>
                <span class="text-sm">Usuarios</span>
            </a>
        </div>

        <!-- Auditoría Sistema - Solo Admin -->
        <div class="menu-item">
            <button onclick="toggleMenu('auditoria')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-shield-alt text-orange-600"></i>
                    <span class="text-sm">Auditoría Sistema</span>
                </div>
                <i id="auditoria-icon" class="fas {{ request()->routeIs('auditoria.*') ? 'fa-chevron-down' : 'fa-chevron-right' }} text-xs"></i>
            </button>
            <div id="auditoria-menu" class="ml-6 mt-1 space-y-1 {{ request()->routeIs('auditoria.*') ? '' : 'hidden' }}">
                <a href="{{ route('auditoria.accesos') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors {{ request()->routeIs('auditoria.accesos') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Accesos al Sistema</a>
                <a href="{{ route('auditoria.operaciones') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors {{ request()->routeIs('auditoria.operaciones') ? 'bg-primary-50 text-primary-700 font-semibold' : '' }}">Operaciones del Sistema</a>
            </div>
        </div>
    @endif

    @if($userRole === 'medico_auditor')
        <!-- Reintegros Pendientes - Solo Médico Auditor -->
        <div class="menu-item">
            <a href="#" class="w-full flex items-center gap-3 p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <i class="fas fa-stethoscope text-blue-600"></i>
                <span class="text-sm">Reintegros Pendientes</span>
                <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">3</span>
            </a>
        </div>

        <!-- Historial de Auditorías - Solo Médico Auditor -->
        <div class="menu-item">
            <button onclick="toggleMenu('auditorias')" class="w-full flex items-center justify-between p-3 text-left font-medium text-gray-700 hover:bg-primary-50 hover:text-primary-700 rounded-lg transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fas fa-history text-green-600"></i>
                    <span class="text-sm">Historial de Auditorías</span>
                </div>
                <i id="auditorias-icon" class="fas fa-chevron-right text-xs"></i>
            </button>
            <div id="auditorias-menu" class="ml-6 mt-1 space-y-1 hidden">
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Casos Aprobados</a>
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Casos Rechazados</a>
                <a href="#" class="block px-3 py-2 text-sm text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded transition-colors">Solicitudes de Información</a>
            </div>
        </div>

    @endif
</nav>