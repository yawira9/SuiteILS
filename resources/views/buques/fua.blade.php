<!-- resources/views/buques/fua.blade.php -->
<x-app-layout>
    @section('title', 'FUA') 
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('buques.show', $buque->id) }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                        Módulo FUA: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto flex fade-in" x-data="fuaData()" x-init="initialize()">
        <div :class="expanded ? 'w-full' : 'w-1/2'" class="transition-all duration-300 pr-4 h-full flex flex-col">
            @if($sistemasEquipos->isEmpty())
                <p>No hay sistemas y equipos asignados a este buque.</p>
            @else
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-4">
                        <input 
                            type="text" 
                            placeholder="Buscar por CJ" 
                            x-model="search" 
                            class="px-4 py-2 border rounded-lg mt-2"
                        />
                    </div>
                    <button @click="expanded = !expanded" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                        <i :class="expanded ? 'fas fa-arrow-left' : 'fas fa-arrow-right'"></i>
                    </button>
                </div>
                <div class="flex-grow overflow-auto rounded-lg" id="scrollable-table">
                    <div class="space-y-4 mr-4 ml-4">
                        @foreach($sistemasEquipos as $equipo)
                            <button x-show="search === '' || '{{ $equipo->mfun }}'.toLowerCase().includes(search.toLowerCase())"
                                    @click="selectEquipo('{{ $equipo->id }}', '{{ $equipo->mfun }}', '{{ $equipo->titulo }}'); if (expanded) expanded = false"
                                    class="w-full text-left px-4 py-4 border border-black rounded flex items-center bg-white shadow-lg hover:bg-gray-100 transition-all duration-300 mr-4">
                                <span class="text-blue-900 font-semibold mr-4">{{ $equipo->mfun }}</span>
                                <span>{{ $equipo->titulo }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div :class="expanded ? 'hidden' : 'w-1/2'" class="transition-all duration-300 pl-4">
            <div x-show="selectedEquipo" class="p-4 bg-white h-full flex flex-col">
                <div class="flex items-center mb-4">
                    <div class="flex flex-col mr-4">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">CJ</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedMfun"></span>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre Equipo</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedTitulo"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
function fuaData() {
    return {
        expanded: false,
        search: '',
        selectedEquipo: null,
        selectedMfun: '',
        selectedTitulo: '',
        equipos: @json($sistemasEquipos),
        initialize() {
            const selectedEquipoId = localStorage.getItem('selectedEquipoId');
            const scrollTop = localStorage.getItem('scrollTop');
            const isExpanded = localStorage.getItem('isExpanded') === 'true';
            if (selectedEquipoId) {
                const equipo = this.equipos.find(e => e.id == selectedEquipoId);
                if (equipo) {
                    this.selectEquipo(equipo.id, equipo.mfun, equipo.titulo);
                }
            }
            if (scrollTop) {
                document.getElementById('scrollable-table').scrollTop = scrollTop;
            }
            this.expanded = isExpanded;
            window.addEventListener('load', () => {
                document.querySelector('.fade-in').classList.add('show');
            });
        },
        selectEquipo(id, mfun, titulo) {
            this.selectedEquipo = id;
            this.selectedMfun = mfun;
            this.selectedTitulo = titulo;
            localStorage.setItem('selectedEquipoId', id);
            localStorage.setItem('isExpanded', false);
        }
    }
}
</script>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    html, body {
        height: 100%;
        overflow: hidden;
    }
    .container {
        height: calc(100vh - 8.5rem);
    }
    .fade-in {
        opacity: 0;
        transition: opacity 0.5s ease-in;
    }
    .fade-in.show {
        opacity: 1;
    }

    .swal2-modal {
        font-family: 'Inter', sans-serif;
    }

    .swal2-modal .swal2-title {
        line-height: 1.2;
        font-size: 25px;
        margin-top: 20px;
        font-weight: bold;
    }

    .swal2-custom-buttons {
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 10px;
    }

    .swal2-misiones-button, .swal2-help-button {
        background-color: transparent;
        color: #6B7280;
        border: 1px solid #6B7280;
        border-radius: 9999px;
        padding: 5px 15px;
        font-size: 12px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .swal2-help-button {
        padding: 5px 10px;
        border-radius: 50%;
    }

    .swal2-misiones-button:hover, .swal2-help-button:hover {
        background-color: #6B7280;
        color: white;
    }
</style>
