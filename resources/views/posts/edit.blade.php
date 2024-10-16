<x-app-layout>
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

            input {
                margin-top: 1rem;
            }

            input::file-selector-button {
                background-color: grey;
                font-weight: bold;
                color: white;
                padding: 0.5em;
                border: thin solid grey;
                border-radius: 3px;
            }

            .btn-save:hover {
                color: green;
            }

            .btn-cancel:hover {
                color: red;
            }
        </style>
    @endpush

    @section('content')
    <div class="container mx-auto px-4">
        <h1 class="pb-8 text-center text-3xl font-bold">MODIFICA IL POST</h1>
        <div style="max-width: 400px;"
            class="max-w-3xl p-4 mx-auto bg-white shadow-lg rounded-lg overflow-hidden animate__animated animate__fadeInUp">
            <div class="">
                <div class="flex items-center justify-between m-2">
                    <span class="text-sm font-semibold text-gray-800">{{ $post->user->name }}</span>
                    <div class="flex items-center">
                        @php
                            $last_activity = $last_activity ?? null;
                            if ($last_activity) {
                                $lastActivity = \Carbon\Carbon::createFromTimestamp($last_activity);
                                $now = \Carbon\Carbon::now();
                                $diffInHours = $lastActivity->diffInHours($now);
                            }
                        @endphp
                        <span class="h-3 w-3 rounded-full mr-2" style="
                            background-color: 
                            @if ($last_activity)
                                @if ($diffInHours < 1)
                                    green
                                @elseif ($diffInHours < 24)
                                    yellow
                                @else
                                    red
                                @endif
                            @else
                                red
                            @endif
                        ">
                        </span>
                        <span class="text-sm text-gray-500">
                            @if ($last_activity)
                                @if ($diffInHours < 1)
                                    Attivo ora
                                @elseif ($diffInHours < 24)
                                    Attivo da {{ $diffInHours }} ore
                                @else
                                    Inattivo da {{ $lastActivity->diffInDays($now) }} giorni
                                @endif
                            @else
                                Inattivo (Nessuna attività)
                            @endif
                        </span>
                    </div>
                </div>

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                    class="form-section px-4" x-data="imagePreview()">
                    @csrf
                    @method('PUT')

                    <!-- Existing Image (hidden when new image is selected) -->
                    <div class="mb-4" x-show="!imageUrl">
                        @if ($post->image)
                            <img src="{{ asset('post_images/' . $post->image) }}" alt="{{ $post->title }}"
                                class="w-full object-cover rounded-md shadow-md border" style="aspect-ratio: 1/1;">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-md">
                                <span class="text-gray-500">Nessuna immagine</span>
                            </div>
                        @endif
                    </div>

                    <!-- Image Preview (shown when new image is selected) -->
                    <div class="mb-4" x-show="imageUrl">
                        <img x-bind:src="imageUrl" alt="Anteprima Immagine"
                            class="w-full object-cover rounded-md shadow-md border" style="aspect-ratio: 1/1;">
                    </div>

                    <!-- Title Input -->
                    <div class="mb-4">
                        <label for="title" class="label-style">Titolo</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required>
                    </div>

                    <!-- Description Input -->
                    <div class="mb-4">
                        <label for="description" class="label-style">Descrizione</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required>{{ old('description', $post->description) }}</textarea>
                    </div>

                    <!-- Image Input -->
<div class="mb-4">
    <label for="image" class="label-style">Immagine</label>
    <input type="file" id="image" name="image" accept="image/*"
        class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
        @change="preview($event)">
    <!-- Messaggio di errore -->
    <template x-if="error">
        <p class="mt-2 text-sm text-red-600" x-text="error"></p>
    </template>
</div>


                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('posts.index') }}" class="btn btn-cancel btn-secondary">Annulla</a>
                        <button type="submit" class="btn btn-save btn-primary">Aggiorna Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
    function imagePreview() {
        return {
            imageUrl: null,
            error: null, // Aggiungiamo una proprietà per gestire l'errore
            preview(event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    if (file.size > 2 * 1024 * 1024) { // Controlliamo se il file supera 2MB
                        this.error = 'L\'immagine è troppo grande (massimo 2MB).';
                        // Non aggiorniamo imageUrl per mantenere l'immagine attuale
                    } else {
                        this.error = null; // Resettiamo l'errore se il file va bene
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imageUrl = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    this.error = null; // Resettiamo l'errore se non è un'immagine valida
                    this.imageUrl = null;
                }
            }
        }
    }
</script>

    @endpush

</x-app-layout>