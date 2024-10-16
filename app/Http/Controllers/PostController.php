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
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $session = \DB::table('sessions')->where('user_id', Auth::id())->first();

        return view('posts.index', [
            'posts' => $posts,
            'last_activity' => $session ? $session->last_activity : null // Passa l'ultimo accesso alla vista
        ]);
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
                // Genera una sottocartella basata sull'MD5 dell'ID utente
                $userFolder = md5(Auth::id());

                // Genera un nome univoco per l'immagine
                $filename = time() . '_' . $request->file('image')->getClientOriginalName();

                // Salva l'immagine nella sottocartella
                $request->file('image')->storeAs($userFolder, $filename, 'post_images');

                // Salva il percorso relativo nell'attributo 'image'
                $post->image = $userFolder . '/' . $filename;
            } catch (\Exception $e) {
                return back()->withErrors(['image' => 'Errore durante il caricamento dell\'immagine.'])->withInput();
            }
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post creato con successo.');
    }


    // Mostra il form per modificare un post esistente
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'Non sei autorizzato a modificare questo post.');
        }

        $session = \DB::table('sessions')->where('user_id', Auth::id())->first();

        return view('posts.edit', [
            'post' => $post,
            'last_activity' => $session ? $session->last_activity : null
        ]);
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
                Storage::disk('post_images')->delete($post->image);
            }

            try {
                // Genera una sottocartella basata sull'MD5 dell'ID utente
                $userFolder = md5(Auth::id());

                // Genera un nome univoco per la nuova immagine
                $filename = time() . '_' . $request->file('image')->getClientOriginalName();

                // Salva la nuova immagine nella sottocartella
                $request->file('image')->storeAs($userFolder, $filename, 'post_images');

                // Salva il percorso relativo nell'attributo 'image'
                $post->image = $userFolder . '/' . $filename;
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
            $like->delete();
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $id,
            ]);
        }

        // Restituisci il conteggio dei "Mi piace"
        $likeCount = $post->likes()->count();

        return response()->json(['success' => true, 'likeCount' => $likeCount]);
    }

    public function toggleSave($id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($user->savedPosts()->where('post_id', $id)->exists()) {
            $user->savedPosts()->detach($id);
        } else {
            $user->savedPosts()->attach($id);
        }

        // Restituisci il risultato
        return response()->json(['success' => true]);
    }

}
