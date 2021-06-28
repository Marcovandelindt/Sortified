<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Music\Artist;
use App\Models\Music\Album;
use App\Models\Music\PlayedTrack;

class Track extends Model
{
    use HasFactory;

    protected $fillables = [
        'spotify_id',
        'album_id',
        'name',
        'duration_ms',
        'disc_number',
        'popularity',
        'track_number'
    ];

    /**
     * The artists that belong to a track
     */
    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    /**
     * Get the albuming beloning to this track
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    /**
     * Get the played tracks beloning to this track
     */
    public function played()
    {
        return $this->hasMany(PlayedTrack::class);
    }

    /**
     * Get the total amount of times a track has been played
     *
     * @return integer
     */
    public function getPlayCount(): int
    {
        return count($this->played);
    }
}
