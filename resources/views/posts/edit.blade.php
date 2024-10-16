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
        <h1 class="pb-8" style="font-size: 3rem; text-align: center; font-weight: bolder;">MODIFICA IL POST</h1>
        <div style="max-width: 400px;"
            class="max-w-3xl p-4 mx-auto bg-white shadow-lg rounded-lg overflow-hidden animate__animated animate__fadeInUp">
            <div class="">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-800">{{ $post->user->name }}</span>
                    <div class="flex items-center">
                        <span class="h-3 w-3 rounded-full mr-2" style="
                                                            background-color: 
                                                            @if ($last_activity)
                                                                                                                                                                                                                                                    @php
                                                                                                                                                                                                                                                        $lastActivity = \Carbon\Carbon::createFromTimestamp($last_activity);
                                                                                                                                                                                                                                                        $now = \Carbon\Carbon::now();
                                                                                                                                                                                                                                                        $diffInHours = $lastActivity->diffInHours($now);
                                                                                                                                                                                                                                                    @endphp
                                                                                                                                                                                                                                                    @if ($diffInHours < 1)
                                                                                                                                                                                                                                                        green; /* Attivo ora */
                                                                                                                                                                                                                                                    @elseif ($diffInHours < 24)
                                                                                                                                                                                                                                                        yellow; /* Attivo da meno di un giorno */
                                                                                                                                                                                                                                                    @else
                                                                                                                                                                                                                                                        red; /* Inattivo da più di un giorno */
                                                                                                                                                                                                                                                    @endif
                                                            @else
                                                                red; /* Nessuna attività */
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

                @if ($post->image)
                    <img src="{{ asset('post_images/' . $post->image) }}" alt="{{ $post->title }}"
                        class="w-full object-cover mb-4" style="aspect-ratio: 1/1;">
                @endif

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                    class="form-section px-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="label-style">Titolo</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="label-style">Descrizione</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2 w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm"
                            required>{{ old('description', $post->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="label-style">Immagine</label>
                        <input type="file" id="image" name="image"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring sm:text-sm">
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
    @endpush

</x-app-layout>