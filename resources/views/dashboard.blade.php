<x-app-layout>
    @section('title', 'Dashboard')
    <div class="container mx-auto px-20 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold mb-4" style="font-family: 'Inter', sans-serif;">Proyectos</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($buques as $buque)
                    <a href="{{ route('buques.show', $buque->id) }}" class="buque-card bg-white shadow-md rounded overflow-hidden group flex flex-col h-full">
                        <img src="{{ $buque->image_url }}" alt="{{ $buque->nombre_proyecto }}" class="w-full h-32 object-cover transition duration-300 ease-in-out group-hover:brightness-75" draggable="false">
                        <div class="p-4 flex-grow flex flex-col">
                            <h2 class="text-xl font-bold mb-2" style="color: #1862B0; font-family: 'Inter', sans-serif;">{{ Str::limit(strtoupper($buque->nombre_proyecto), 50) }}</h2>
                            <p class="flex-grow break-words" style="font-family: 'Inter', sans-serif;">{{ Str::limit($buque->descripcion_proyecto, 100) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');

            searchInput.addEventListener('input', function () {
                if (searchInput.value === '') {
                    window.location.href = "{{ route('buques.index') }}";
                }
            });

            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const buqueId = this.getAttribute('data-id');
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
                            document.getElementById(`delete-form-${buqueId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
