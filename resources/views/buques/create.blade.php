<x-app-layout>
    @section('title', 'Crear Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Nuevo Registro de Buque</h1>
        <div x-data="{ 
                tab: 'datos_basicos', 
                operaciones: [], 
                suboperaciones: ['Ayuda Humanitaria', 'Búsqueda y Rescate', 'Combate a la piratería', 'Combate contra el terrorismo', 'Interdicción Marítima', 'Operaciones de Desembarco', 'Operaciones de paz y ayuda humanitaria', 'Operaciones de soporte logístico', 'Seguridad y control de tráfico marítimo', 'Soporte interdicción marítima', 'Soporte y colaboración a autoridades civiles en caso de disturbios y revueltas'],
                nuevaOperacion: '',
                mostrarPopup: false,
                editarIndex: null,
                agregarOperacion() {
                    if (this.nuevaOperacion.trim() === '') {
                        Swal.fire({
                            title: 'Error',
                            text: 'El nombre de la operación no puede estar vacío',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    this.operaciones.push({ nombre: this.nuevaOperacion, suboperaciones: [], guardada: false, editando: false });
                    this.nuevaOperacion = '';
                    this.mostrarPopup = false;
                },
                editarOperacion(index) {
                    this.operaciones[index].editando = true;
                    this.editarIndex = index;
                },
                guardarEdicion(index) {
                    this.operaciones[index].editando = false;
                    this.operaciones[index].guardada = true;
                    this.editarIndex = null;
                },
                eliminarOperacion(index) {
                    this.operaciones.splice(index, 1);
                },
                suboperacionSeleccionada(index, suboperacion) {
                    if (this.operaciones[index].suboperaciones.includes(suboperacion)) {
                        this.operaciones[index].suboperaciones = this.operaciones[index].suboperaciones.filter(s => s !== suboperacion);
                    } else {
                        this.operaciones[index].suboperaciones.push(suboperacion);
                    }
                },
                isSuboperacionSeleccionada(suboperacion) {
                    return this.operaciones.some(op => op.suboperaciones.includes(suboperacion));
                },
                guardarOperacion(index) {
                    this.operaciones[index].guardada = true;
                }
            }" class="bg-white shadow rounded-lg p-6">
            <!-- Pestañas -->
            <nav class="flex mb-4 space-x-2">
                <button @click="tab = 'datos_basicos'" :class="{'bg-blue-700 text-white': tab === 'datos_basicos', 'bg-gray-200 text-gray-700': tab !== 'datos_basicos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-ship mr-2"></i>
                    Datos Básicos
                </button>
                <button @click="tab = 'misiones'" :class="{'bg-blue-700 text-white': tab === 'misiones', 'bg-gray-200 text-gray-700': tab !== 'misiones'}" class="px-4 py-2 flex rounded items-center">
                    <i class="fas fa-pencil-alt mr-2"></i>
                    Operaciones y Misiones
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
            <form action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div x-show="tab === 'datos_basicos'" x-cloak>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700">Nombre del Proyecto o Buque</label>
                            <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="tipo_buque" class="block text-sm font-medium text-gray-700">Tipo de Buque</label>
                            <input type="text" name="tipo_buque" id="tipo_buque" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="descripcion_proyecto" class="block text-sm font-medium text-gray-700">Descripción del Proyecto</label>
                            <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="mt-1 block w-full h-24 border border-gray-300 rounded-md shadow-sm" maxlength="500" required></textarea>
                        </div>
                        <div>
                            <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía en Horas</label>
                            <input type="number" name="autonomia_horas" id="autonomia_horas" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Buque</label>
                            <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
                    </div>
                </div>

                <div x-show="tab === 'misiones'" x-cloak>
                    <div class="mb-5">
                        <button type="button" @click="mostrarPopup = true" class="bg-blue-700 text-white px-4 py-2 rounded">Agregar Operación</button>
                    </div>
                    <template x-for="(operacion, index) in operaciones" :key="index">
                        <div class="mb-4 border rounded p-4 relative">
                            <div class="flex justify-between items-center mb-2">
                                <input x-show="operacion.editando" type="text" x-model="operacion.nombre" class="border border-gray-300 rounded-md shadow-sm p-2 w-full mb-4" placeholder="Nombre de la Operación">
                                <h3 x-show="!operacion.editando" class="text-lg font-bold" x-text="operacion.nombre"></h3>
                                <div class="flex items-center">
                                    <button @click="editarOperacion(index)" class="text-gray-500 hover:text-gray-700" x-show="!operacion.editando && operacion.guardada">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button @click="eliminarOperacion(index)" class="text-red-500 hover:text-red-700 ml-2" x-show="operacion.editando">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <template x-for="suboperacion in suboperaciones" :key="suboperacion">
                                    <div class="flex items-center" :class="{'opacity-50': isSuboperacionSeleccionada(suboperacion) && !operacion.suboperaciones.includes(suboperacion)}">
                                        <label class="relative inline-flex items-center cursor-pointer mr-3">
                                            <input type="checkbox" :name="'operaciones[' + index + '][suboperaciones][]'" :value="suboperacion" class="mr-2" :disabled="(isSuboperacionSeleccionada(suboperacion) && !operacion.suboperaciones.includes(suboperacion)) || (operacion.guardada && !operacion.editando)" @change="suboperacionSeleccionada(index, suboperacion)">
                                            <span x-text="suboperacion"></span>
                                        </label>
                                    </div>
                                </template>
                            </div>
                            <button type="button" @click="guardarEdicion(index)" class="bg-blue-700 text-white px-4 py-2 rounded mt-4" x-show="operacion.editando">Guardar Edición</button>
                            <button type="button" @click="guardarOperacion(index)" class="bg-blue-700 text-white px-4 py-2 rounded mt-4" x-show="!operacion.guardada && !operacion.editando">Guardar Operación</button>
                        </div>
                    </template>

                    <div x-show="mostrarPopup" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50" x-cloak>
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-lg font-bold mb-4">Agregar Operación</h2>
                            <input type="text" x-model="nuevaOperacion" class="border border-gray-300 rounded-md shadow-sm p-2 w-full mb-4" placeholder="Nombre de la Operación">
                            <div class="flex justify-end">
                                <button type="button" @click="agregarOperacion" class="bg-blue-700 text-white px-4 py-2 rounded mr-2">Guardar</button>
                                <button type="button" @click="mostrarPopup = false" class="bg-red-700 text-white px-4 py-2 rounded">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenido de Colaboradores -->
                <div x-show="tab === 'colaboradores'" x-cloak>
                    <div class="mb-5 opacity-65">
                        <p><i class="fa-solid fa-circle-info text-gray-700"></i> Los colaboradores ingresados en esta sección son los mismos que aparecerán en los anexos generales exportados en PDF de los diferentes módulos.</p>
                    </div>
                    <div id="colaboradores-container" class="space-y-4 mb-4"></div>
                    <button type="button" class="bg-blue-700 text-white px-4 py-2 rounded" onclick="agregarColaborador()">Agregar Colaborador</button>
                </div>

                <!-- Contenido de Sistema y Equipos -->
                <div x-show="tab === 'sistema_equipos'" x-cloak>
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
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                            <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                        <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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
                                                        <input type="checkbox" name="sistemas_equipos[]" value="{{ $equipo->id }}">
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

function agregarOperacion() {
    if (this.nuevaOperacion.trim() === '') {
        Swal.fire({
            title: 'Error',
            text: 'El nombre de la operación no puede estar vacío',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    this.operaciones.push({ nombre: this.nuevaOperacion, suboperaciones: [], guardada: false, editando: false });
    this.nuevaOperacion = '';
    this.mostrarPopup = false;
}

function editarOperacion(index) {
    this.operaciones[index].editando = true;
    this.editarIndex = index;
}

function guardarEdicion(index) {
    this.operaciones[index].editando = false;
    this.operaciones[index].guardada = true;
    this.editarIndex = null;
}

function eliminarOperacion(index) {
    this.operaciones.splice(index, 1);
}

function suboperacionSeleccionada(index, suboperacion) {
    if (this.operaciones[index].suboperaciones.includes(suboperacion)) {
        this.operaciones[index].suboperaciones = this.operaciones[index].suboperaciones.filter(s => s !== suboperacion);
    } else {
        this.operaciones[index].suboperaciones.push(suboperacion);
    }
}

function isSuboperacionSeleccionada(suboperacion) {
    return this.operaciones.some(op => op.suboperaciones.includes(suboperacion));
}

function guardarOperacion(index) {
    this.operaciones[index].guardada = true;
}
</script>
