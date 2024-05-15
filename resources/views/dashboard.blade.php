<!-- resources/views/dashboard.blade.php -->

<x-app-layout>
    @section('title', 'Dashboard')
    <div class="container mx-auto px-20 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-4" style="font-family: 'Inter', sans-serif;">Proyectos</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($buques as $buque)
                    <div class="bg-white shadow-md rounded overflow-hidden group flex flex-col h-full">
                        @if ($buque->image_path)
                            <img src="{{ Storage::url($buque->image_path) }}" alt="{{ $buque->nombre_proyecto }}" class="w-full h-32 object-cover transition duration-300 ease-in-out group-hover:brightness-75" draggable="false">
                        @else
                            <img src="{{ asset('storage/default/image.png') }}" alt="Default Image" class="w-full h-32 object-cover transition duration-300 ease-in-out group-hover:brightness-75" draggable="false">
                        @endif
                        <div class="p-4 flex-grow flex flex-col">
                            <h2 class="text-xl font-bold mb-2" style="color: #1862B0; font-family: 'Inter', sans-serif;">{{ Str::limit(strtoupper($buque->nombre_proyecto), 50) }}</h2>
                            <p class="flex-grow break-words" style="font-family: 'Inter', sans-serif;">{{ Str::limit($buque->descripcion_proyecto, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
