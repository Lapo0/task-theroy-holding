<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Mostra la lista dei post
    public function index()
    {
        $posts = Post::with('user', 'likes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('posts.index', ['posts' => $posts]);
    }

    // Mostra il form per creare un nuovo post
    public function create()
    {
        return view('posts.create');
    }

    // Salva un nuovo post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->input('title');
        $post->description = $request->input('description');

        if ($request->hasFile('image')) {
            try {
                $path = $request->file('image')->store('posts', 'public');
                $post->image = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Errore durante il caricamento dell\'immagine.'])->withInput();
            }
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post creato con successo.');
    }

    // Mostra un singolo post
    public function show($id)
    {
        $post = Post::with('user', 'likes')->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    // Mostra il form per modificare un post esistente
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Non sei autorizzato a modificare questo post.');
        }

        return view('posts.edit', compact('post'));
    }

    // Aggiorna un post esistente
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Non sei autorizzato a modificare questo post.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->title = $request->input('title');
        $post->description = $request->input('description');

        if ($request->hasFile('image')) {
            // Elimina l'immagine precedente se esiste
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            try {
                $path = $request->file('image')->store('posts', 'public');
                $post->image = $path;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Errore durante il caricamento dell\'immagine.'])->withInput();
            }
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post aggiornato con successo.');
    }

    // Elimina un post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Non sei autorizzato a eliminare questo post.');
        }

        // Elimina l'immagine associata se esiste
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post eliminato con successo.');
    }

    // Aggiungi o rimuovi un "Mi piace"
    public function toggleLike($id)
    {
        $post = Post::findOrFail($id);
        $like = Like::where('user_id', Auth::id())->where('post_id', $id)->first();

        if ($like) {
            // Se il "Mi piace" esiste, lo rimuove
            $like->delete();
        } else {
            // Altrimenti, lo aggiunge
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $id,
            ]);
        }

        return redirect()->back();
    }

    // Salva o rimuove un post dai salvati
    public function toggleSave($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($user->savedPosts()->where('post_id', $id)->exists()) {
            // Se il post è già salvato, lo rimuove
            $user->savedPosts()->detach($id);
        } else {
            // Altrimenti, lo salva
            $user->savedPosts()->attach($id);
        }

        return redirect()->back();
    }
}
