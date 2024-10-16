<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @push('styles')
        <!-- Animate.css per Animazioni -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endpush

    @section('content')
    @if($posts && $posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div
                    class="bg-white p-4 shadow-md rounded-lg overflow-hidden animate__animated animate__fadeInUp hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-800">{{ $post->user->name }}</span>
                        <div class="flex items-center justify-between m-2">
                            <div class="flex items-center">
                                <span class="h-3 w-3 rounded-full mr-2" style="width: 0.75rem; height: 0.75rem;;
                                                        background-color: 
                                                        @php
                                                            $last_activity = $userSessions[$post->user_id]->last_activity ?? null;
                                                            if ($last_activity) {
                                                                $lastActivity = \Carbon\Carbon::createFromTimestamp($last_activity);
                                                                $now = \Carbon\Carbon::now();
                                                                $diffInHours = $lastActivity->diffInHours($now);
                                                            }
                                                        @endphp
                                                        @if ($last_activity)
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
                                        Inattivo
                                    @endif
                                </span>
                            </div>
                        </div>

                    </div>

                    @if ($post->image)
                        <img src="{{ asset('post_images/' . $post->image) }}" alt="{{ $post->title }}" class="w-full object-cover"
                            style="aspect-ratio: 1/1;">
                    @endif
                    <div class="p-3"
                        style="display: flex; flex-direction: column; justify-content: space-between; height: 30vh;">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($post->description, 100, '...') }}</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form"
                                    data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="button"
                                        class="like-button flex items-center text-red-500 hover:text-red-600 pr-3"
                                        data-liked="{{ Auth::user()->likes->where('post_id', $post->id)->count() ? 'true' : 'false' }}">
                                        <i
                                            class="pr-1 {{ Auth::user()->likes->where('post_id', $post->id)->count() ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                        <span class="like-count">{{ $post->likes->count() }}</span>
                                    </button>
                                </form>

                                <form action="{{ route('posts.save', $post->id) }}" method="POST" class="save-form"
                                    data-post-id="{{ $post->id }}">
                                    @csrf
                                    <button type="button"
                                        class="save-button flex items-center text-blue-500 hover:text-blue-600"
                                        data-saved="{{ Auth::user()->savedPosts->contains($post->id) ? 'true' : 'false' }}">
                                        <i
                                            class="pr-1 {{ Auth::user()->savedPosts->contains($post->id) ? 'fas fa-bookmark' : 'far fa-bookmark' }}"></i>
                                    </button>
                                </form>
                            </div>

                            @if ($post->user_id == Auth::id())
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                        onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <i class="fas fa-trash-alt"></i>
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
            Nessun post trovato. <a href="{{ route('posts.create') }}" class="text-blue-500 hover:underline">Crea un nuovo
                post</a>.
        </div>
    @endif
    @endsection

    @push('scripts')
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.closest('.like-form').getAttribute('data-post-id');
                    const isLiked = this.getAttribute('data-liked') === 'true';

                    fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ liked: !isLiked })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Aggiorna l'icona e il contatore
                                this.querySelector('i').className = isLiked ? 'far fa-heart' : 'fas fa-heart';
                                this.querySelector('.like-count').innerText = data.likeCount;
                                this.setAttribute('data-liked', !isLiked);
                            }
                        });
                });
            });
            document.querySelectorAll('.save-button').forEach(button => {
                button.addEventListener('click', function () {
                    const postId = this.closest('.save-form').getAttribute('data-post-id');
                    const isSaved = this.getAttribute('data-saved') === 'true';

                    fetch(`/posts/${postId}/save`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ saved: !isSaved })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Aggiorna l'icona e il testo
                                this.querySelector('i').className = isSaved ? 'far fa-bookmark' : 'fas fa-bookmark';
                                this.querySelector('.save-text').innerText = isSaved ? 'Salva' : 'Salvato';
                                this.setAttribute('data-saved', !isSaved);
                            }
                        });
                });
            });
        </script>
    @endpush
</x-app-layout>