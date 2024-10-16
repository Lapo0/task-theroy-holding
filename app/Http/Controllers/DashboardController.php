<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Recupera tutti i post con i loro autori e i like
        $posts = Post::with('user', 'likes')->orderBy('created_at', 'desc')->paginate(10);

        // Recupera le ultime attività di tutti gli utenti
        $userSessions = \DB::table('sessions')->get()->keyBy('user_id');

        return view('dashboard', compact('posts', 'userSessions'));
    }

    // Toggle like
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

    // Toggle save
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
