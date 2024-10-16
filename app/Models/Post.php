<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
    ];

    // Relazione con l'utente
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relazione con i like
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relazione con i post salvati (attraverso la tabella pivot)
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_posts');
    }

    // Accessor per l'URL dell'immagine
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('post_images/' . $this->image) : null;
    }
    

    // Metodo per aggiornare l'immagine del post
    public function updateImage($photo)
    {
        tap($this->image, function ($previous) use ($photo) {
            $filename = $photo->hashName();

            // Salva la foto nel disco 'public' sotto la cartella 'posts'
            $photo->storeAs('posts', $filename, 'public');

            $this->forceFill([
                'image' => 'posts/' . $filename,
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->image
            ? asset('post_images/' . $this->image)
            : $this->defaultProfilePhotoUrl();
    }
}
