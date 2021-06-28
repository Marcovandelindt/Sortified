<?php

namespace App\Repositories\Music;

use Illuminate\Support\Collection;

use App\Repositories\Music\Eloquent\PlayedTrackRepository;

use App\Models\Music\PlayedTrack;

interface PlayedTrackRepositoryInterface
{
    public function today($limit = null);

    public function all($results = null);

    public function calculateListeningTime($timeFrame);

    public function getTopTracks($limit);

    public function getWeekly($startDate, $endDate);

    public function getTrackCountPerTimeLastWeek();

    public function getByDatesAndTimes($startDate, $endDate, $startingTime, $endingTime);

    public function calculateAveragePlays($timeFrame, $startDate = null);

    public function getPlayedTracksCount($timeFrame, $startDate = null);

    public function getByDates($startDate, $endDate);

    public function getUniquePlayedTracks($timeFrame, $paginatedResults = null);
}
