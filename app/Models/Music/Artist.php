<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Services\Music\PlayedTrackService;

use App\Models\Music\Track;
use App\Models\Music\Album;
use App\Models\Music\PlayedTrack;

class Artist extends Model
{
    use HasFactory;

    protected $fillables = [
        'spotify_id',
        'name',
        'image',
        'popularity',
        'followers',
        'play_count',
    ];

    /**
     * The tracks that belong to an artist
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }

    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    /**
     * Check if an artist has a track
     *
     * @param int $trackId
     *
     * @return bool true|false
     */
    public function hasTrack($trackId): bool
    {
        return $this->tracks()
            ->where('track_id', $trackId)
            ->exists();
    }

    /**
     * Check if an artist has an album
     *
     * @param int $albumId
     *
     * @return bool true|false
     */
    public function hasAlbum($albumId): bool
    {
        return $this->albums()
            ->where('album_id', $albumId)
            ->exists();
    }


    /**
     * Check how often a artist has been played
     */
    public function getPlayCount()
    {
        $played = [];

        foreach ($this->tracks as $track) {
            foreach ($track->played as $play) {
                $played[] = $play;
            }
        }

        return count($played);
    }

    /**
     * Get the total listening time of an artist
     *
     * @return string
     */
    public function getTotalListeningTime()
    {
        $played = [];

        foreach ($this->tracks as $track) {
            $results = PlayedTrack::where('track_id', $track->id)->get();
            if (count($results) > 1) {
                foreach ($results as $result) {
                    $played[] = $result;
                }
            } else {
                $played[] = $results[0];
            }
        }

        $playedTrackService = new PlayedTrackService();

        return $playedTrackService->calculateListeningTime($played, true);
    }
}
