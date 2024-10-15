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

        /* Stili per i messaggi di successo e errore */
        .message-success {
            @apply text-green-600 text-sm mt-2 animate__animated animate__fadeIn;
        }

        .message-error {
            @apply text-red-600 text-sm mt-2 animate__animated animate__fadeIn;
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

        /* Stili per le immagini */
        .post-image {
            @apply w-full h-64 object-cover rounded-lg;
        }

        /* Stili per i pulsanti */
        .button-group {
            @apply flex items-center space-x-4;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden animate__animated animate__fadeInUp">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-image">
            @endif
            <div class="p-6">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-4">{{ $post->title }}</h1>
                <p class="text-gray-700 mb-4">{{ $post->description }}</p>
                <p class="text-sm text-gray-500 mb-4">Autore: {{ $post->user->name }}</p>

                <div class="flex items-center space-x-4 mb-6">
                    <form action="{{ route('posts.like', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-red-500 hover:text-red-600">
                            @if ($post->likes->where('user_id', Auth::id())->count())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                                </svg>
                                <span>{{ $post->likes->count() }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.172 5.172a4 4 0 015.656 0L12 6.343l3.172-3.171a4 4 0 115.656 5.656L12 17.657l-8.828-8.829a4 4 0 010-5.656z" />
                                </svg>
                                <span>{{ $post->likes->count() }}</span>
                            @endif
                        </button>
                    </form>

                    <form action="{{ route('posts.save', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-blue-500 hover:text-blue-600">
                            @if (Auth::user()->savedPosts->contains($post->id))
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v12l7-3 7 3V5a2 2 0 00-2-2H5z" />
                                </svg>
                                <span>Salvato</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V5z" />
                                </svg>
                                <span>Salva</span>
                            @endif
                        </button>
                    </form>
                </div>

                @if ($post->user_id == Auth::id())
                    <div class="button-group">
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn-primary flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a2.828 2.828 0 114 4L10.5 19.5H5v-4.732l9.232-9.232z" />
                            </svg>
                            Modifica
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-secondary flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Elimina
                            </button>
                        </form>
                    </div>
                @endif

                <a href="{{ route('posts.index') }}" class="mt-6 inline-flex items-center text-blue-500 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Torna alla lista dei post
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Alpine.js per interattività -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush
