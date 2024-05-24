<!-- resources/views/buques/gres.blade.php -->
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
                        Módulo FUA: <span style="text-transform: uppercase; color: #1862B0;">{{ $buque->nombre_proyecto }}</span>
                    </h1>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-4">Contenido del Módulo FUA</h2>
        <p>Aquí puedes agregar el contenido y funcionalidad específica para el módulo FUA.</p>
    </div>
</x-app-layout>

