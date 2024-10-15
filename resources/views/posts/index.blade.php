@extends('layouts.app')

@push('styles')
    <!-- Animate.css per Animazioni -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Tailwind CSS CDN (se non già incluso nel tuo progetto) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 animate__animated animate__fadeInDown">Lista dei Post</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-6 animate__animated animate__fadeIn">
                {{ session('success') }}
            </div>
        @endif

        @if($posts && $posts->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($posts as $post)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden animate__animated animate__fadeInUp hover:shadow-xl transition-shadow duration-300">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($post->description, 100, '...') }}</p>
                            <p class="text-sm text-gray-500 mb-4">Autore: {{ $post->user->name }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.172 5.172a4 4 0 015.656 0L12 8.343l3.172-3.171a4 4 0 115.656 5.656L12 21.657l-8.828-8.829a4 4 0 010-5.656z" />
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5v14l7-3 7 3V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                                                </svg>
                                                <span>Salva</span>
                                            @endif
                                        </button>
                                    </form>
                                </div>

                                @if ($post->user_id == Auth::id())
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M17.414 2.586a2 2 0 010 2.828L7.828 15H5v-2.828l9.586-9.586a2 2 0 012.828 0zM4 13v3h3l9.586-9.586-3-3L4 13z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v1H2v2h1v10a2 2 0 002 2h10a2 2 0 002-2V7h1V5h-2V4a2 2 0 00-2-2H6zm2 5a1 1 0 112 0 1 1 0 01-2 0zm3-3H7v1h4V4z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginazione -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-gray-100 text-gray-700 p-4 rounded animate__animated animate__fadeIn">
                Nessun post trovato. <a href="{{ route('posts.create') }}" class="text-blue-500 hover:underline">Crea un nuovo post</a>.
            </div>
        @endif

        <!-- Pulsante per Creare Nuovo Post -->
        <div class="mt-8 text-center">
            <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Crea Nuovo Post
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Alpine.js per interattività -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endpush
