<x-app-layout>
    @section('title', 'Crear Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Nuevo Registro de Buque</h1>
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
                <button @click="tab = 'sistema_equipos'" :class="{'bg-blue-700 text-white': tab === 'sistema_equipos', 'bg-gray-200 text-gray-700': tab !== 'sistema_equipos'}" class="px-4 py-2 rounded flex items-center">
                    <i class="fas fa-cogs mr-2"></i>
                    Sistema y Equipos
                </button>
            </nav>

            <form action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Contenido de Datos Básicos -->
                <div x-show="tab === 'datos_basicos'">
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

                <div x-show="tab === 'misiones'">
                </div>

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
