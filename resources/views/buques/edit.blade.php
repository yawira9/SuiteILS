<x-app-layout>
    @section('title', 'Editar Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Editar Buque</h1>
        <div x-data="{ tab: 'datos_basicos' }" class="bg-white shadow rounded-lg p-6">
            <!-- Pestañas -->
            <nav class="flex mb-4 space-x-2">
                <button @click="tab = 'datos_basicos'" :class="{'bg-blue-700 text-white': tab === 'datos_basicos', 'bg-gray-200 text-gray-700': tab !== 'datos_basicos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-ship mr-2"></i>
                    Datos Básicos
                </button>
                <button @click="tab = 'misiones'" :class="{'bg-blue-700 text-white': tab === 'misiones', 'bg-gray-200 text-gray-700': tab !== 'misiones'}" class="px-4 py-2 flex rounded items-center">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Misiones
                </button>
                <button @click="tab = 'colaboradores'" :class="{'bg-blue-700 text-white': tab === 'colaboradores', 'bg-gray-200 text-gray-700': tab !== 'colaboradores'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Colaboradores
                </button>
                <button @click="tab = 'sistema_equipos'" :class="{'bg-blue-700 text-white': tab === 'sistema_equipos', 'bg-gray-200 text-gray-700': tab !== 'sistema_equipos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    Sistema y Equipos
                </button>
            </nav>

            <form action="{{ route('buques.update', $buque->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Contenido de Datos Básicos -->
                <div x-show="tab === 'datos_basicos'">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700">Nombre del Proyecto o Buque</label>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" value="{{ $buque->nombre_proyecto }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="tipo_buque" class="block text-sm font-medium text-gray-700">Tipo de Buque</label>
                            <input type="text" name="tipo_buque" id="tipo_buque" value="{{ $buque->tipo_buque }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="descripcion_proyecto" class="block text-sm font-medium text-gray-700">Descripción del Proyecto</label>
                            <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="mt-1 block w-full h-24 border border-gray-300 rounded-md shadow-sm" maxlength="500" required>{{ $buque->descripcion_proyecto }}</textarea>
                        </div>
                        <div>
                            <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía en Horas</label>
                            <input type="number" name="autonomia_horas" id="autonomia_horas" value="{{ $buque->autonomia_horas }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Buque</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                            @if ($buque->image_path)
                                <img src="{{ Storage::url($buque->image_path) }}" alt="{{ $buque->nombre_proyecto }}" class="mt-4 w-32 h-32 object-cover">
                            @endif
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </div>

                <!-- Contenido de Misiones -->
                <div x-show="tab === 'misiones'">
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Misiones extraidas de Armada República de Colombia (ARC), "Doctrina de Material Naval. Tomo III. Mantenimiento. Segunda edición," Dirección de Doctrina Naval, Bogotá, D.C., Colombia, 2022.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Columna 1 -->
                        <div class="space-y-4">
                            @foreach (['Ayuda Humanitaria', 'Búsqueda y Rescate', 'Combate a la piratería', 'Combate contra el terrorismo'] as $mision)
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer mr-3">
                                        <input type="checkbox" name="misiones[{{ $mision }}]" value="1" {{ in_array($mision, $misiones_activas) ? 'checked' : '' }} class="mr-2">
                                        <span>{{ $mision }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Columna 2 -->
                        <div class="space-y-4">
                            @foreach (['Interdicción Marítima', 'Operaciones de Desembarco', 'Operaciones de paz y ayuda humanitaria', 'Operaciones de soporte logístico'] as $mision)
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer mr-3">
                                        <input type="checkbox" name="misiones[{{ $mision }}]" value="1" {{ in_array($mision, $misiones_activas) ? 'checked' : '' }} class="mr-2">
                                        <span>{{ $mision }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <!-- Columna 3 -->
                        <div class="space-y-4">
                            @foreach (['Seguridad y control de tráfico marítimo', 'Soporte interdicción marítima', 'Soporte y colaboración a autoridades civiles en caso de disturbios y revueltas'] as $mision)
                                <div class="flex items-center">
                                    <label class="relative inline-flex items-center cursor-pointer mr-3">
                                        <input type="checkbox" name="misiones[{{ $mision }}]" value="1" {{ in_array($mision, $misiones_activas) ? 'checked' : '' }} class="mr-2">
                                        <span>{{ $mision }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Contenido de Colaboradores -->
                <div x-show="tab === 'colaboradores'">
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Los colaboradores ingresados en esta sección son los mismos que aparecerán en los anexos generales exportados en PDF de los diferentes módulos.</p>
                    </div>
                    <div id="colaboradores-container" class="space-y-4 mb-4">
                        @foreach ($buque->colaboradores as $index => $colaborador)
                            <div id="colaborador-{{ $index }}" class="colaborador-item grid grid-cols-4 gap-4" data-index="{{ $index }}">
                                <div>
                                    <label for="col_cargo_{{ $index }}" class="block text-sm font-medium text-gray-700">Cargo</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_cargo]" id="col_cargo_{{ $index }}" value="{{ $colaborador->col_cargo }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div>
                                    <label for="col_nombre_{{ $index }}" class="block text-sm font-medium text-gray-700">Nombres y Apellidos Completos</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_nombre]" id="col_nombre_{{ $index }}" value="{{ $colaborador->col_nombre }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div>
                                    <label for="col_entidad_{{ $index }}" class="block text-sm font-medium text-gray-700">Entidad</label>
                                    <input type="text" name="colaboradores[{{ $index }}][col_entidad]" id="col_entidad_{{ $index }}" value="{{ $colaborador->col_entidad }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="flex items-end">
                                    <button type="button" class="bg-red-700 text-white px-4 py-1 rounded remove-colaborador" data-id="{{ $colaborador->id }}" onclick="confirmarEliminarColaborador({{ $index }})">Eliminar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="agregarColaborador()">Agregar Colaborador</button>
                </div>

                <!-- Contenido de Sistema y Equipos -->
                <div x-show="tab === 'sistema_equipos'">
                    <div class="container mx-auto px-4 py-8 sm:px-20">
                        <div class="px-2 sm:px-4">
                            <div x-data="{ open: null }">
                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="mdi mdi-ferry mr-2 text-2xl"></i> 100 - Casco y Estructuras
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($sistemas_equipos_100 as $equipo)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="mdi mdi-engine mr-2 text-2xl"></i>200 - Máquinaria y Propulsión
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($sistemas_equipos_200 as $equipo)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="mdi mdi-lightning-bolt mr-2 text-2xl"></i>300 - Planta Eléctrica
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($sistemas_equipos_300 as $equipo)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="mdi mdi-ship-wheel mr-2 text-2xl"></i>400 - Comando y Vigilancia
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($sistemas_equipos_400 as $equipo)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="mdi mdi-robot-industrial mr-2 text-2xl"></i>500 - Sistemas Auxiliares
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($sistemas_equipos_500 as $equipo)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div x-data="{ open: false }" class="mb-2">
                                    <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                        <i class="fa-solid fa-couch mr-2 text-2xl"></i>600 - Acabados y Amoblamiento
                                        <span x-show="!open" class="ml-2">▼</span>
                                        <span x-show="open" class="ml-2">▲</span>
                                    </button>
                                    <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($sistemas_equipos_600 as $equipo)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div x-data="{ open: false }" class="mb-2">
                                <button type="button" @click="open = !open" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex items-center">
                                    <i class="fa-solid fa-triangle-exclamation mr-2 text-2xl"></i>700 - Armamento
                                    <span x-show="!open" class="ml-2">▼</span>
                                    <span x-show="open" class="ml-2">▲</span>
                                </button>
                                <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded max-h-64 overflow-y-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CJ</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($sistemas_equipos_700 as $equipo)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->mfun }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $equipo->titulo }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}" {{ in_array($equipo->id, $equipos_seleccionados) ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function agregarColaborador() {
    const contenedor = document.getElementById('colaboradores-container');
    const index = contenedor.children.length;
    const div = document.createElement('div');
    div.classList.add('grid', 'grid-cols-1', 'sm:grid-cols-2', 'lg:grid-cols-4', 'gap-4', 'mb-4');
    div.setAttribute('id', `colaborador-${index}`);
    div.innerHTML = `
        <div>
            <label for="col_cargo_${index}" class="block text-sm font-medium text-gray-700">Cargo</label>
            <input type="text" name="colaboradores[${index}][col_cargo]" id="col_cargo_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="col_nombre_${index}" class="block text-sm font-medium text-gray-700">Nombres y Apellidos Completos</label>
            <input type="text" name="colaboradores[${index}][col_nombre]" id="col_nombre_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div>
            <label for="col_entidad_${index}" class="block text-sm font-medium text-gray-700">Entidad</label>
            <input type="text" name="colaboradores[${index}][col_entidad]" id="col_entidad_${index}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>
        <div class="flex items-end">
            <button type="button" class="bg-red-700 text-white px-4 py-1 rounded mt-2 remove-colaborador" onclick="confirmarEliminarColaborador(${index})">Eliminar</button>
        </div>
    `;
    contenedor.appendChild(div);
}

function confirmarEliminarColaborador(index) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            eliminarColaborador(index);
        }
    });
}

function eliminarColaborador(index) {
    const colaboradorItem = document.getElementById(`colaborador-${index}`);
    colaboradorItem.remove();
}
</script>
