@extends('layouts.app')

@push('styles')
    <!-- Animate.css per Animazioni -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Heroicons -->
    <script src="https://unpkg.com/heroicons@1.0.6/dist/heroicons.min.js"></script>
    <!-- Tailwind CSS (se non già incluso nel tuo progetto) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Stili personalizzati */
        .btn-edit {
            @apply inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 transition duration-300;
        }

        .btn-delete {
            @apply inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition duration-300;
        }

        .btn-like, .btn-save {
            @apply flex items-center space-x-1 text-gray-600 hover:text-gray-800 transition-colors duration-200;
        }

        .btn-like.liked {
            @apply text-red-500;
        }

        .btn-save.saved {
            @apply text-blue-500;
        }

        .post-image {
            @apply w-full h-64 object-cover rounded-lg;
        }

        .back-link {
            @apply flex items-center text-blue-500 hover:underline mt-6;
        }

        .back-link svg {
            @apply h-5 w-5 mr-2;
        }

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
                    <!-- Like Button -->
                    <form action="{{ route('posts.like', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-like {{ $post->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}">
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

                    <!-- Save Button -->
                    <form action="{{ route('posts.save', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-save {{ Auth::user()->savedPosts->contains($post->id) ? 'saved' : '' }}">
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
                        <!-- Edit Button -->
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn-edit flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a2 2 0 010 2.828L7.828 15H5v-2.828l9.586-9.586a2 2 0 012.828 0z" />
                            </svg>
                            Modifica
                        </a>
                        <!-- Delete Button -->
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Elimina
                            </button>
                        </form>
                    </div>
                @endif

                <a href="{{ route('posts.index') }}" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
