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
                            <button id="viewPdfButton" class="bg-blue-500 text-white px-4 py-2 rounded"><i class="fa-solid fa-file-export"></i></button>
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
                            <td class="px-6 py-4 break-words">
                                <input type="text" 
                                    class="border rounded px-2 py-1 w-full" 
                                    :value="getEquipoTitulo('{{ $equipo->id }}', '{{ $equipo->titulo }}')" 
                                    @keydown.enter="updateEquipoTitulo('{{ $equipo->id }}', $event.target.value)">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap" x-text="getMec('{{ $equipo->id }}')"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <i class="fa-solid fa-pen-to-square text-blue-500 cursor-pointer" 
                                @click="selectEquipo('{{ $equipo->id }}', '{{ $equipo->mfun }}', '{{ $equipo->titulo }}', '{{ $equipo->pivot->mec }}', '{{ $equipo->pivot->image }}'); 
                                if (expanded) expanded = false"></i>
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
            <div x-show="selectedEquipo" class="p-4 bg-white h-full flex flex-col">
                <div class="flex items-center mb-4 relative-container" style="position: relative;">
                    <div class="flex flex-col mr-4">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">CJ</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedMfun"></span>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nombre Equipo</span>
                        <span class="px-4 py-2 border rounded bg-gray-100" x-text="selectedTitulo"></span>
                    </div>
                </div>

                <div class="flex items-start mb-4">
                    <div class="flex flex-col mr-4" style="min-width: 150px;">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">MEC</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 mb-2" x-text="selectedMec ? selectedMec : 'MEC sin asignar'"></span>
                        <button @click="asignarMec" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Asignar MEC</button>
                    </div>
                    <div class="flex flex-col flex-grow">
                        <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Diagrama de decisión</span>
                        <span class="px-4 py-2 border rounded bg-gray-100 flex justify-center items-center" style="min-width: 200px; min-height: 100px;">
                            <img :src="selectedImage ? getImageSrc(selectedImage) : 'http://127.0.0.1:8000/storage/images/ImageNullGres.png'" alt="Diagrama" class="w-full h-auto cursor-pointer" @click="expandImage">
                        </span>
                    </div>
</div>

                <div id="expanded-image-container" class="hidden fixed inset-0 bg-black bg-opacity-95 flex justify-center items-center z-50">
                    <button id="close-expanded-image" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
                    <img id="expanded-image" src="" alt="Diagrama" class="max-w-full max-h-full">
                </div>

                <div class="flex flex-col">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Observaciones</span>
                    <div id="observaciones-tabla" class="border rounded px-2 py-1 w-full h-24 overflow-auto"></div>
                </div>
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
        selectedImage: '',
        imagesPorEquipo: {},
        equipos: @json($sistemasEquipos),
        observacionesPorEquipo: {},
        decisionPath: '',

        initialize() {
            const firstEquipo = this.equipos[0];
            this.equipos.forEach(equipo => {
                this.imagesPorEquipo[equipo.id] = equipo.pivot.image || null;
                if (equipo.pivot.image) {
                    this.selectEquipo(equipo.id, equipo.mfun, equipo.titulo, equipo.pivot.mec, equipo.pivot.image);
                }
            });

            if (firstEquipo) {
                this.selectEquipo(firstEquipo.id, firstEquipo.mfun, firstEquipo.titulo, firstEquipo.pivot.mec, firstEquipo.pivot.image);
            }

            window.addEventListener('load', () => {
                document.querySelector('.fade-in').classList.add('show');
            });

            document.querySelectorAll('.px-4.py-2.border.rounded.bg-gray-100.flex.justify-center.items-center img').forEach(img => {
                img.addEventListener('click', this.expandImage.bind(this));
            });

            document.getElementById('close-expanded-image').addEventListener('click', this.closeExpandedImage.bind(this));
        },

        expandImage(event) {
            const expandedImageContainer = document.getElementById('expanded-image-container');
            const expandedImage = document.getElementById('expanded-image');
            expandedImage.src = event.target.src;
            expandedImageContainer.classList.remove('hidden');
            expandedImageContainer.style.display = 'flex';
        },

        closeExpandedImage() {
            const expandedImageContainer = document.getElementById('expanded-image-container');
            expandedImageContainer.classList.add('hidden');
            expandedImageContainer.style.display = 'none';
        },

        selectEquipo(id, mfun, titulo, mec, image) {
            this.selectedEquipo = id;
            this.selectedMfun = mfun;
            this.selectedTitulo = titulo;
            this.selectedMec = mec;
            this.selectedImage = image || this.imagesPorEquipo[id] || null;
            this.actualizarObservacionesTabla();
        },

        getImageSrc(image) {
            if (!image) {
                return `{{ url('storage/images/ImageNullGres.png') }}`;
            }
            return `{{ url('storage') }}/${image}`;
        },

            getMec(id) {
                let equipo = this.equipos.find(e => e.id == id);
                return equipo ? equipo.pivot.mec : 'MEC sin asignar';
            },

            getEquipoTitulo(id, defaultTitulo) {
                let equipo = this.equipos.find(e => e.id == id);
                return equipo ? (equipo.pivot.titulo || defaultTitulo) : defaultTitulo;
            },

            updateEquipoTitulo(id, titulo) {
                fetch(`/buques/{{ $buque->id }}/sistemas-equipos/${id}/titulo`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ titulo: titulo })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Título actualizado correctamente') {
                        let equipo = this.equipos.find(e => e.id == id);
                        if (equipo) {
                            equipo.pivot.titulo = titulo;
                        }
                        Swal.fire('Actualizado', 'Título actualizado correctamente', 'success');
                    } else {
                        Swal.fire('Error', 'No se pudo actualizar el título', 'error');
                    }
                });
            },

            asignarMec() {
                this.decisionPath = '';
                this.pregunta1();
            },

            pregunta1() {
                Swal.fire({
                    title: '¿SE PIERDE LA CAPACIDAD DEL SISTEMA SI EL EQUIPO QUEDA INOPERATIVO?',
                    text: 'Describa la capacidad que se pierde en caso de ser afirmativo',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.pregunta2();
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.updateMec('MEC 1', 'diagramas/0.png');
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta1');
                    }
                });
            },

            pregunta2() {
                Swal.fire({
                    title: '¿REPRESENTA UN EFECTO ADVERSO SOBRE EL PERSONAL, EL SISTEMA O EL MEDIO AMBIENTE?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.pregunta3();
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.pregunta4();
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta2');
                    }
                });
            },

            pregunta3() {
                Swal.fire({
                    title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SISTEMA PARA MITIGAR EL EFECTO ADVERSO PROVOCADO?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.pregunta4();
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.updateMec('MEC 4', 'diagramas/110.png');
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta3');
                    }
                });
            },

            pregunta4() {
                Swal.fire({
                    title: '¿LA CADENA DE SUCESOS CAUSA ALGUNA DEGRADACIÓN SOBRE ALGUNA DE LAS MISIONES?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.pregunta5();
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.updateMec('MEC 1', 'diagramas/1110.png');
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta4');
                    }
                });
            },

            pregunta5() {
                Swal.fire({
                    title: '¿EXISTEN REDUNDANCIAS DENTRO DEL SUBSISTEMA?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.pregunta6();
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.pregunta7();
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta5');
                    }
                });
            },

            pregunta6() {
                Swal.fire({
                    title: '¿MITIGA COMPLETAMENTE EL EFECTO DE LA DEGRADACIÓN?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    denyButtonText: 'No',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.updateMec('MEC 1', 'diagramas/111111.png');
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.pregunta7();
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta6');
                    }
                });
            },

            pregunta7() {
                Swal.fire({
                    title: '¿DE QUÉ TAMAÑO SERÍAN LAS PÉRDIDAS?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Menores o una misión',
                    denyButtonText: 'Más de una misión',
                    cancelButtonText: 'Observaciones',
                    cancelButtonColor: '#3dd960',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.decisionPath += '1';
                        this.updateMec('MEC 2', this.getDiagramImage());
                    } else if (result.isDenied) {
                        this.decisionPath += '0';
                        this.updateMec('MEC 3', this.getDiagramImage());
                    } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                        this.mostrarPopupObservaciones('pregunta7');
                    }
                });
            },

            getDiagramImage() {
                const diagramMap = {
                    '0': '0.png',
                    '100': '100.png',
                    '110': '110.png',
                    '1110': '1110.png',
                    '10100': '10100.png',
                    '10101': '10101.png',
                    '10111': '10111.png',
                    '101100': '101100.png',
                    '101101': '101101.png',
                    '111100': '111100.png',
                    '111101': '111101.png',
                    '111111': '111111.png',
                    '1111100': '1111100.png',
                    '1111101': '1111101.png'
                };
                return `{{ url('storage/diagramas') }}/${diagramMap[this.decisionPath] || '0.png'}`;
            },

            updateMec(mec, image) {
                const equipoSeleccionado = this.equipos.find(e => e.id == this.selectedEquipo);

                fetch(`/buques/{{ $buque->id }}/sistemas-equipos/${this.selectedEquipo}/mec`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ mec: mec, image: image, observaciones: this.observacionesPorEquipo[this.selectedEquipo] || {} })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'MEC actualizado correctamente') {
                        equipoSeleccionado.pivot.mec = mec;
                        equipoSeleccionado.pivot.image = image;
                        this.imagesPorEquipo[this.selectedEquipo] = image;
                        this.selectedMec = mec;
                        this.selectedImage = image;

                        let imagenElement = document.querySelector('.absolute-image img');
                        if (imagenElement) {
                            imagenElement.src = this.getImageSrc(this.selectedImage);
                            imagenElement.dataset.imageSrc = this.selectedImage;
                        }

                        Swal.fire('Actualizado', 'MEC actualizado correctamente', 'success');
                    } else {
                        Swal.fire('Error', 'No se pudo actualizar el MEC', 'error');
                    }
                });
            },

            mostrarPopupObservaciones(pregunta) {
                const _this = this;
                Swal.fire({
                    title: 'Observaciones',
                    html: `<textarea id="observaciones-textarea" class="swal2-textarea" placeholder="Escribe tus observaciones aquí...">${this.observacionesPorEquipo[this.selectedEquipo] && this.observacionesPorEquipo[this.selectedEquipo][pregunta] ? this.observacionesPorEquipo[this.selectedEquipo][pregunta] : ''}</textarea>`,
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const observaciones = Swal.getPopup().querySelector('#observaciones-textarea').value;
                        if (!_this.observacionesPorEquipo[_this.selectedEquipo]) {
                            _this.observacionesPorEquipo[_this.selectedEquipo] = {};
                        }
                        _this.observacionesPorEquipo[_this.selectedEquipo][pregunta] = observaciones;

                        localStorage.setItem('observacionesPorEquipo', JSON.stringify(_this.observacionesPorEquipo));
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Guardado', 'Tus observaciones han sido guardadas.', 'success').then(() => {
                            _this.actualizarObservacionesTabla();
                            _this[pregunta](); 
                        });
                    } else if (result.isDismissed) {
                        _this[pregunta](); 
                    }
                });
            },

            validateCJ(cj) {
                const regex = /^[0-9]{4}[0-9A-Za-z]$/;
                return regex.test(cj);
            },

            addEquipo(cj, nombre) {
                fetch(`/buques/{{ $buque->id }}/sistemas-equipos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ mfun: cj, titulo: nombre })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === 'Equipo agregado correctamente') {
                        this.equipos.push(data.equipo);
                        Swal.fire('Agregado', 'Nuevo equipo agregado correctamente', 'success');
                    } else {
                        Swal.fire('Error', 'No se pudo agregar el equipo', 'error');
                    }
                });
            },

            copyData() {
                alert('Funcionalidad de copiar implementada');
            },

            viewPdf() {
                window.location.href = `{{ route('buques.viewPdf', ['buque' => $buque->id]) }}`;
            },

            actualizarObservacionesTabla() {
                const observacionesDiv = document.getElementById('observaciones-tabla');
                let observacionesHTML = '<table class="min-w-full divide-y divide-gray-200"><thead><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pregunta</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observación</th></tr></thead><tbody>';
                
                if (this.observacionesPorEquipo[this.selectedEquipo]) {
                    for (const [pregunta, observacion] of Object.entries(this.observacionesPorEquipo[this.selectedEquipo])) {
                        observacionesHTML += `<tr><td class="px-6 py-4 whitespace-nowrap">${pregunta}</td><td class="px-6 py-4 whitespace-nowrap">${observacion}</td></tr>`;
                    }
                }
                
                observacionesHTML += '</tbody></table>';
                observacionesDiv.innerHTML = observacionesHTML;
            },
        }
    }

    document.getElementById('viewPdfButton').addEventListener('click', function() {
        window.open(`{{ route('buques.viewPdf', ['buque' => $buque->id]) }}`, '_blank');
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }
        .container {
            height: calc(100vh - 8.5rem);
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
            margin-top: 50px; /* Aumentar el margen superior */
            border-radius: 10px;
        }

        .swal2-modal .swal2-title {
            line-height: 1.2;
            font-size: 20px;
            margin-top: 70px; /* Ajustar el margen superior para el título */
            font-weight: bold;
            color: #464647;
        }

        .swal2-custom-buttons {
            position: absolute;
            top: 0; /* Cambiar top a 0 */
            right: 10px;
            display: flex;
            gap: 10px;
            margin-top: 60px; /* Aumentar el margen superior para separar los botones del título */
            margin-right: 20px;
        }

        .swal2-misiones-button, .swal2-help-button, .swal2-speak-button {
            background-color: transparent;
            color: #464647;
            border: 1.5px solid #3b3d40;
            border-radius: 15px;
            padding: 10px 20px; /* Aumentar el tamaño del padding */
            font-size: 14px; /* Aumentar el tamaño */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            margin-bottom: 50px;
            font-weight: bold;

        }

        .swal2-back-button {
            background-color: transparent;
            color: #464647;
            border: 1px solid #3b3d40;
            border-radius: 9999px;
            padding: 5px 10px; /* Reducir el tamaño del padding */
            font-size: 14px; /* Mantener el tamaño de la fuente */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            font-weight: bold;
            border: none;
        }

        .swal2-back-button:hover {
            color: #3458eb;
        }

        .swal2-help-button, .swal2-speak-button {
            padding: 10px 15px; /* Aumentar el tamaño del padding */
            border-radius: 15px;
        }

        .swal2-misiones-button:hover, .swal2-help-button:hover, .swal2-speak-button:hover {
            background-color: #6B7280;
            color: white;
        }

        /* Estilos adicionales para los botones principales */
        .swal2-confirm, .swal2-cancel, .swal2-deny {
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 5px;
        }

        .img-container img {
            width: 100%;
            height: auto;
        }

        #expanded-image-container {
            display: none;
        }
        #expanded-image {
            max-width: 90%;
            max-height: 90%;
        }
    </style>
</x-app-layout>
