@extends('layouts.app')

@push('styles')
    <!-- Animate.css per Animazioni -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Tailwind CSS CDN (se non già incluso nel tuo progetto) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Personalizzazione dei pulsanti */
        .btn-primary {
            @apply bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300;
        }

        .btn-secondary {
            @apply bg-gray-600 text-white font-semibold py-2 px-4 rounded hover:bg-gray-700 transition duration-300;
        }

        /* Stili per i messaggi di errore */
        .error-message {
            @apply bg-red-500 text-white p-4 rounded mb-6 animate__animated animate__fadeIn;
        }

        /* Stili per le etichette */
        .label-style {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }

        /* Stili per il contenitore del modulo */
        .form-section {
            @apply bg-white shadow-md rounded-lg p-6 animate__animated animate__fadeInUp;
        }

        /* Effetto di pulsante al caricamento */
        .loading-spinner {
            @apply animate-spin h-5 w-5 mr-3 border-2 border-t-2 border-gray-200 rounded-full;
        }

        /* Stili per le icone di input */
        .input-icon {
            @apply absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none;
        }

        /* Stili per i contenitori degli input */
        .input-container {
            @apply relative;
        }

        /* Tooltip */
        .tooltip {
            @apply relative group;
        }

        .tooltip .tooltip-text {
            @apply absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-700 text-white text-xs rounded-md opacity-0 transition-opacity duration-300;
        }

        .tooltip:hover .tooltip-text {
            @apply opacity-100;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-photo-preview {
                @apply w-24 h-24;
            }
        }

        /* Additional Custom Styles */
        .custom-button {
            @apply bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300;
        }

        .custom-button:hover {
            @apply bg-blue-700;
        }

        /* Input Error Styling */
        .input-error-message {
            @apply text-red-600 text-sm mt-2;
        }

        /* Textarea Styling */
        textarea::placeholder {
            @apply text-gray-400;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 animate__animated animate__fadeInDown">Crea Nuovo Post</h1>

        @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="max-w-lg mx-auto">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf

                <div class="mb-4">
                    <x-label for="title" value="{{ __('Titolo') }}" class="label-style" />
                    <div class="relative input-container">
                        <span class="input-icon">
                            <!-- Icona del titolo (esempio: pencil icon) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-2 0l-7-7a2 2 0 00-2.828 0l-3 3a2 2 0 000 2.828l7 7a2 2 0 002.828 0l3-3a2 2 0 000-2.828z" />
                            </svg>
                        </span>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring input-focus sm:text-sm" required placeholder="Inserisci il titolo del post">
                    </div>
                    <x-input-error for="title" class="mt-2 input-error-message" />
                </div>

                <div class="mb-4">
                    <x-label for="description" value="{{ __('Descrizione') }}" class="label-style" />
                    <div class="relative input-container">
                        <span class="input-icon">
                            <!-- Icona della descrizione (esempio: chat icon) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.025 9.025 0 01-4.918-1.252L3 20l1.252-4.918A9.025 9.025 0 0112 12z" />
                            </svg>
                        </span>
                        <textarea id="description" name="description" class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring input-focus sm:text-sm" rows="4" required placeholder="Inserisci la descrizione del post">{{ old('description') }}</textarea>
                    </div>
                    <x-input-error for="description" class="mt-2 input-error-message" />
                </div>

                <div class="mb-4">
                    <x-label for="image" value="{{ __('Immagine') }}" class="label-style" />
                    <div class="relative input-container">
                        <span class="input-icon">
                            <!-- Icona dell'immagine (esempio: camera icon) -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-4.553a2 2 0 012.828 0l.007.007a2 2 0 010 2.828L17 14.828M9 9l-4.553 4.553a2 2 0 01-2.828 0L.172 13.172a2 2 0 010-2.828L4.725 6.727a2 2 0 012.828 0L9 9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l2.293 2.293a1 1 0 001.414-1.414L17.414 15l2.293-2.293a1 1 0 00-1.414-1.414L16 13.586l-2.293-2.293a1 1 0 00-1.414 1.414L14.586 15l-2.293 2.293a1 1 0 001.414 1.414L16 16.414z" />
                            </svg>
                        </span>
                        <input type="file" id="image" name="image" class="block w-full pl-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring input-focus sm:text-sm">
                    </div>
                    <x-input-error for="image" class="mt-2 input-error-message" />
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <button type="submit" class="btn-primary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Salva
                    </button>
                    <a href="{{ route('posts.index') }}" class="btn-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Alpine.js per interattività -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush
