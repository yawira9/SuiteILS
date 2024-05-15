<!-- resources/views/buques/index.blade.php -->

<x-app-layout>
    @section('title', 'Buques')
    <div class="container mx-auto px-4 py-8 sm:px-20">
        <div class="px-2 sm:px-4">
            <div class="flex flex-col sm:flex-row justify-between mb-4">
                <h1 class="text-2xl font-bold mb-2 sm:mb-0" style="font-family: 'Inter', sans-serif;">Buques</h1>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <form method="GET" action="{{ route('buques.index') }}" class="flex w-full sm:w-3/4">
                        <input type="text" name="search" placeholder="Buscar por nombre de proyecto" class="form-input flex-grow px-4 py-2 border rounded-l" value="{{ request()->input('search') }}">
                        <button type="submit" style="font-family: 'Inter', sans-serif;" class="bg-green-400 text-white px-4 py-2 rounded-r">Buscar</button>
                    </form>
                    <a href="{{ route('buques.create') }}" class="bg-green-400 text-white px-4 py-2 rounded flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>Nuevo
                    </a>
                </div>
            </div>
            <div class="bg-white shadow-md rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de Buque
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Autonomía de Horas
                            </th>
                            <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($buques as $buque)
                            <tr>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->nombre_proyecto }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->tipo_buque }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 break-words">{{ Str::limit($buque->descripcion_proyecto, 50) }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $buque->autonomia_horas }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('buques.destroy', $buque->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded delete-button">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    No se encontraron resultados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-center">
                {{ $buques->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.closest('.delete-form');
                    Swal.fire({
                        title: '¿Estás seguro de borrar el proyecto?',
                        text: "No podrás revertir esta acción",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminalo',
                        cancelButtonText: 'No, cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
