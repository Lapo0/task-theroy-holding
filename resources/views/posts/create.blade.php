<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crea un nuovo post') }}
        </h2>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <style>
            .btn-primary {
                @apply bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300;
            }

            .btn-secondary {
                @apply bg-gray-600 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition duration-300;
            }

            .label-style {
                @apply block text-sm font-medium text-gray-700 mb-1;
            }

            .form-section {
                @apply bg-white shadow-md rounded-lg p-6 animate__animated animate__fadeInUp;
            }

            input[type="file"] {
                margin-top: 1rem;
            }

            input[type="file"]::file-selector-button {
                background-color: grey;
                font-weight: bold;
                color: white;
                padding: 0.5em;
                border: thin solid grey;
                border-radius: 3px;
            }

            .placeholder-image {
                width: 100%;
                height: 0;
                padding-top: 100%;
                background-image: url('https://via.placeholder.com/300.png?text=Anteprima+Immagine');
                background-size: cover;
                background-position: center;
                border-radius: 0.5rem;
            }

            .btn-save:hover {
                color: green;
            }

            .btn-cancel:hover {
                color: red;
            }
        </style>
    @endpush

    <div class="container mx-auto px-4 py-8">
        <div style="max-width: 400px;"
            class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden animate__animated animate__fadeInUp">
            <div class="p-6">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                    class="form-section" x-data="imagePreview()">
                    @csrf

                    <!-- Placeholder Image -->
                    <div class="mb-4 placeholder-image" x-show="!imageUrl && !error"></div>

                    <!-- Image Preview -->
                    <div class="mb-4" x-show="imageUrl">
                        <img x-bind:src="imageUrl" alt="Anteprima Immagine" style="aspect-ratio: 1/1;"
                            class="w-full object-cover rounded-md shadow-md border" />
                    </div>

                    <!-- Messaggio di errore -->
                    <template x-if="error">
                        <p class="mb-4 text-sm text-red-600" x-text="error"></p>
                    </template>

                    <div class="mb-4">
                        <label for="title" class="label-style">Titolo</label>
                        <input type="text" id="title" name="title"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required placeholder="Inserisci il titolo del post">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="label-style">Descrizione</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required placeholder="Inserisci la descrizione del post"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="label-style">Immagine</label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            @change="preview($event)">

                        <template x-if="error">
                            <p class="mt-2 text-sm text-red-600" x-text="error"></p>
                        </template>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('posts.index') }}" class="btn-cancel btn-secondary">Annulla</a>
                        <button type="submit" class="btn-save btn-primary">Crea Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            function imagePreview() {
                return {
                    imageUrl: null,
                    error: null, // Aggiunta della proprietà per l'errore
                    preview(event) {
                        const file = event.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            if (file.size > 2 * 1024 * 1024) { // Verifica se il file supera i 2MB
                                this.error = 'L\'immagine è troppo grande (massimo 2MB).';
                                // Non aggiorniamo imageUrl per mantenere l'immagine placeholder
                                this.imageUrl = null;
                            } else {
                                this.error = null; // Reset dell'errore se il file va bene
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.imageUrl = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        } else {
                            this.error = 'Seleziona un\'immagine valida.';
                            this.imageUrl = null;
                        }
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>