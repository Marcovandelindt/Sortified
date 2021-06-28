<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Music\Track;
use App\Models\Music\Artist;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'name',
        'image',
        'release_date',
        'total_tracks',
        'type',
        'play_count',
    ];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }
}
