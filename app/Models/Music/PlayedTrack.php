<?php

namespace App\Models\Music;

use App\Models\Music\Track;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayedTrack extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * Get the track associated with the played track
     */
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
