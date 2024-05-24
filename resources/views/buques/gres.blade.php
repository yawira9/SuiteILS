<x-app-layout>
    @section('title', 'GRES')
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('buques.show', $buque->id) }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                        Módulo GRES: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto flex fade-in" x-data="gresData()" x-init="initialize()">
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
                        <div class="flex space-between mt-2 gap-3">
                            <button @click="copyData" class="bg-blue-500 text-white px-4 py-2 rounded">Copiar</button>
                            <button @click="exportData" class="bg-blue-500 text-white px-4 py-2 rounded">Exportar</button>
                        </div>
                    </div>
                    <button @click="expanded = !expanded" class="text-blue-500 hover:text-blue-700 focus:outline-none">
                        <i :class="expanded ? 'fas fa-arrow-left' : 'fas fa-arrow-right'"></i>
                    </button>
                </div>
                <div class="flex-grow overflow-auto rounded-lg" id="scrollable-table">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">MEC</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sistemasEquipos as $equipo)
                                <tr x-show="search === '' || '{{ $equipo->mfun }}'.toLowerCase().includes(search.toLowerCase())" class="hover:bg-gray-200">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                    <td class="px-6 py-4 break-words">{{ $equipo->titulo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap" x-text="getMec('{{ $equipo->id }}')"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <i class="fa-solid fa-pen-to-square text-blue-500 cursor-pointer" @click="selectEquipo('{{ $equipo->id }}', '{{ $equipo->mfun }}', '{{ $equipo->titulo }}', '{{ $equipo->pivot->mec }}'); if (expanded) expanded = false"></i>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div :class="expanded ? 'hidden' : 'w-1/2'" class="transition-all duration-300 pl-4">
            <!-- Contenido adicional para la parte derecha -->
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
                <div class="flex items-center mb-4">
                    <div class="flex flex-col mr-4">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">MEC</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedMec ? selectedMec : 'MEC sin asignar'"></span>
                        <button @click="asignarMec" class="bg-blue-500 text-white px-4 py-2 rounded w-full mt-2">Asignar MEC</button>
                    </div>
                </div>
                <!-- Aquí puedes agregar más contenido relacionado con el equipo seleccionado -->
            </div>
        </div>
    </div>

    <script>
        function gresData() {
            return {
                expanded: false,
                search: '',
                selectedEquipo: null,
                selectedMfun: '',
                selectedTitulo: '',
                selectedMec: '',
                equipos: @json($sistemasEquipos),
                initialize() {
                    const selectedEquipoId = localStorage.getItem('selectedEquipoId');
                    const scrollTop = localStorage.getItem('scrollTop');
                    const isExpanded = localStorage.getItem('isExpanded') === 'true';
                    if (selectedEquipoId) {
                        const equipo = this.equipos.find(e => e.id == selectedEquipoId);
                        if (equipo) {
                            this.selectEquipo(equipo.id, equipo.mfun, equipo.titulo, equipo.pivot.mec);
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
                selectEquipo(id, mfun, titulo, mec) {
                    this.selectedEquipo = id;
                    this.selectedMfun = mfun;
                    this.selectedTitulo = titulo;
                    this.selectedMec = mec;
                    localStorage.setItem('selectedEquipoId', id);
                    localStorage.setItem('isExpanded', false);
                },
                getMec(id) {
                    let equipo = this.equipos.find(e => e.id == id);
                    return equipo ? equipo.pivot.mec : 'MEC sin asignar';
                },
                asignarMec() {
                    Swal.fire({
                        title: '¿SE PIERDE LA CAPACIDAD DEL SISTEMA SI EL EQUIPO QUEDA INOPERATIVO?',
                        text: 'Describa la capacidad que se pierde en caso de ser afirmativo',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.pregunta2();
                        } else if (result.isDenied) {
                            this.updateMec('MEC 1');
                        }
                    });
                },
                pregunta2() {
                    Swal.fire({
                        title: '¿ES CRÍTICO PARA LA OPERACIÓN DEL BUQUE?',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.pregunta3();
                        } else if (result.isDenied) {
                            this.pregunta4();
                        }
                    });
                },
                pregunta3() {
                    Swal.fire({
                        title: '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE?',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.pregunta4();
                        } else if (result.isDenied) {
                            this.updateMec('MEC 4');
                        }
                    });
                },
                pregunta4() {
                    Swal.fire({
                        title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA DEGRADACIÓN SOBRE ALGUNA DE LAS MISIONES?',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.pregunta5();
                        } else if (result.isDenied) {
                            this.updateMec('MEC 1');
                        }
                    });
                },
                pregunta5() {
                    Swal.fire({
                        title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SUBSISTEMA?',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.pregunta6();
                        } else if (result.isDenied) {
                            this.pregunta7();
                        }
                    });
                },
                pregunta6() {
                    Swal.fire({
                        title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA DEGRADACIÓN?',
                        showDenyButton: true,
                        confirmButtonText: 'Sí',
                        denyButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.updateMec('MEC 1');
                        } else if (result.isDenied) {
                            this.pregunta7();
                        }
                    });
                },
                pregunta7() {
                    Swal.fire({
                        title: '¿DE QUÉ TAMAÑO SERÍAN LAS PÉRDIDAS?',
                        showDenyButton: true,
                        confirmButtonText: 'Menores o una misión',
                        denyButtonText: 'Más de una misión'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.updateMec('MEC 2');
                        } else if (result.isDenied) {
                            this.updateMec('MEC 3');
                        }
                    });
                },
                updateMec(mec) {
                    fetch(`/buques/{{ $buque->id }}/sistemas-equipos/${this.selectedEquipo}/mec`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ mec: mec })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === 'MEC actualizado correctamente') {
                            let equipo = this.equipos.find(e => e.id == this.selectedEquipo);
                            if (equipo) {
                                equipo.pivot.mec = mec;
                                this.selectedMec = mec;
                            }
                            Swal.fire('Actualizado', 'MEC actualizado correctamente', 'success').then(() => {
                                localStorage.setItem('scrollTop', document.getElementById('scrollable-table').scrollTop);
                                localStorage.setItem('isExpanded', this.expanded);
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', 'No se pudo actualizar el MEC', 'error');
                        }
                    });
                },
                copyData() {
                    // Implementar lógica de copiado de datos
                    alert('Funcionalidad de copiar implementada');
                },
                exportData() {
                    // Implementar lógica de exportación de datos
                    alert('Funcionalidad de exportar implementada');
                }
            }
        }
    </script>
</x-app-layout>

<!-- Ensure only one instance of Alpine.js is included -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
    html, body {
        height: 100%;
        overflow: hidden; /* Disable page overflow */
    }
    .container {
        height: calc(100vh - 8.5rem); /* Adjust container height to full viewport height minus navbar */
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
        margin-top: 2rem;
        font-weight: bold;
    }
    
    
</style>
