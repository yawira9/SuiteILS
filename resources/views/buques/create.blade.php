<!-- resources/views/buques/create.blade.php -->

<x-app-layout>
    @section('title', 'Crear Buque')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-4">Crear Nuevo Buque</h1>
        <form action="{{ route('buques.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nombre_proyecto" class="block text-sm font-medium text-gray-700">Nombre del Proyecto o Buque</label>
                <input type="text" name="nombre_proyecto" id="nombre_proyecto" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="tipo_buque" class="block text-sm font-medium text-gray-700">Tipo de Buque</label>
                <input type="text" name="tipo_buque" id="tipo_buque" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="descripcion_proyecto" class="block text-sm font-medium text-gray-700">Descripción del Proyecto</label>
                <textarea name="descripcion_proyecto" id="descripcion_proyecto" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" maxlength="500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="autonomia_horas" class="block text-sm font-medium text-gray-700">Autonomía en Horas</label>
                <input type="number" name="autonomia_horas" id="autonomia_horas" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Buque</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</x-app-layout>
