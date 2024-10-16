<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Determina quale tipo di post visualizzare
        $filter = $request->get('filter', 'all'); // Default a 'all'

        // Recupera i post in base al filtro
        if ($filter === 'liked') {
            $posts = Post::with('user', 'likes')
                ->whereHas('likes', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } elseif ($filter === 'saved') {
            $posts = Post::with('user', 'savedByUsers') // Cambiato a savedByUsers
                ->whereHas('savedByUsers', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $posts = Post::with('user', 'likes')->orderBy('created_at', 'desc')->paginate(10);
        }

        // Recupera le ultime attività di tutti gli utenti
        $userSessions = \DB::table('sessions')
            ->select('user_id', 'last_activity', 'ip_address', 'user_agent')
            ->whereNotNull('user_id')
            ->get();

        return view('dashboard', compact('posts', 'userSessions', 'filter'));
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
