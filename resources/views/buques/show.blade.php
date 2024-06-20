<x-app-layout>
    @section('title', $buque->nombre_proyecto) 
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/dashboard') }}" class="text-blue-900 hover:text-blue-900 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                    </a>
                    <h1 class="text-2xl font-bold ml-2" style="font-family: 'Inter', sans-serif;">
                    </h1>
                </div>
            </div>
        </div>
    </nav>
    <div class="relative w-full h-64 md:h-96 overflow-hidden">
        @if ($buque->image_path)
            <img src="{{ Storage::url($buque->image_path) }}" alt="{{ $buque->nombre_proyecto }}" class="absolute inset-0 w-full h-full object-cover">
        @else
            <img src="{{ asset('storage/default/image.png') }}" alt="Default Image" class="absolute inset-0 w-full h-full object-cover">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-75"></div><div class="absolute bottom-4 left-4 text-left text-white max-w-3xl mb-2" style="font-family: 'Inter', sans-serif;">
    <h1 class="text-4xl font-bold uppercase">{{ $buque->nombre_proyecto }}</h1>
    <p class="text-lg mt-2 break-words whitespace-normal">
        {{ $buque->descripcion_proyecto }}
    </p>
</div>
    </div>

    <div class="flex flex-col items-center justify-center h-full" x-data="{ showGres: false, showFua: false, showItem3: false }" x-init="setTimeout(() => showGres = true, 100); setTimeout(() => showFua = true, 300); setTimeout(() => showItem3 = true, 500)" style="margin-top: 8%">
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8 mt-8">
            <a href="{{ route('buques.gres', $buque->id) }}" x-show="showGres" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="bg-blue-500 text-white w-48 h-24 md:w-48 md:h-48 rounded-lg text-2xl font-bold hover:bg-blue-700 flex items-center justify-center">GRES</a>
            <a href="{{ route('buques.fua', $buque->id) }}" x-show="showFua" x-transition:enter="transform transition ease-in-out duration-600" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="bg-blue-500 text-white w-48 h-24 md:w-48 md:h-48 rounded-lg text-2xl font-bold hover:bg-blue-700 flex items-center justify-center">FUA</a>
            <a href="{{ route('buques.gres2', $buque->id) }}" x-show="showItem3" x-transition:enter="transform transition ease-in-out duration-700" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="bg-blue-500 text-white w-48 h-24 md:w-48 md:h-48 rounded-lg text-2xl font-bold hover:bg-blue-700 flex items-center justify-center">GRES 2</a>
        </div>
    </div>


    <!-- Ensure only one instance of Alpine.js is included -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            display: flex;
            flex-direction: column;
            margin: 0;
        }

        #app {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .gradient-overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 1));
        }
    </style>
</x-app-layout>
