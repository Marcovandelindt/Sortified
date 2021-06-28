<?php

namespace App\Repositories\Music\Eloquent;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;

use App\Repositories\Music\PlayedTrackRepositoryInterface;
use App\Services\Music\PlayedTrackService;

use App\Models\Music\PlayedTrack;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PlayedTrackRepository implements PlayedTrackRepositoryInterface
{
    protected $playedTrackService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->playedTrackService = new PlayedTrackService;
    }

    /**
     * Get all played tracks from the current date
     *
     * @param mixed $limit
     *
     * @return Collection
     */
    public function today($limit = null)
    {
        if (!empty($limit)) {
            return PlayedTrack::orderBy('played_at', 'DESC')
                ->where('played_date', date('Y-m-d'))
                ->paginate($limit);
        } else {
            return PlayedTrack::orderBy('played_at', 'DESC')
                ->where('played_date', date('Y-m-d'))
                ->get();
        }
    }

    /**
     * Calculate the listening time
     *
     * @param string $timeFrame
     * @param bool   $formatted
     */
    public function calculateListeningTime($timeFrame, $formatted = false)
    {
        $playedTracks = [];

        switch ($timeFrame) {
            case 'daily':
                $playedTracks = $this->today();
                break;
            case 'last-week':
                $playedTracks = $this->getWeekly(Carbon::today()->startOfWeek()->subDays(7)->format('Y-m-d'), Carbon::today()->endOfWeek()->subDays(7)->format('Y-m-d'));
                break;
            case '-2 week':
                $playedTracks = $this->getWeekly(Carbon::today()->startOfWeek()->subDays(14)->format('Y-m-d'), Carbon::today()->endOfWeek()->subDays(14)->format('Y-m-d'));
                break;
            case 'total':
                $playedTracks = $this->all();
                break;
            default:
                $playedTracks = $this->today();
                break;
        }

        return $this->playedTrackService->calculateListeningTime($playedTracks, $formatted);
    }

    /**
     * Get all played tracks
     * @param $results
     */
    public function all($results = null)
    {
        if (is_numeric($results)) {
            $tracks = PlayedTrack::orderBy('played_at', 'DESC')->paginate($results);
        } else {
            $tracks = PlayedTrack::all();
        }

        return $tracks;
    }

    /**
     * Get top tracks based
     *
     * @param $limit
     */
    public function getTopTracks($limit)
    {
        return PlayedTrack::select('*', DB::raw('count(*) as total'))
            ->groupBy('track_id')
            ->orderByRaw('COUNT(*) DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all tracks for a certain week
     *
     * @param string $startDate
     * @param string $endDate
     *
     * @return \EloquentCollection
     */
    public function getWeekly($startDate, $endDate)
    {
        return PlayedTrack::select('*')
            ->where('played_date', '>=', $startDate)
            ->where('played_date', '<=', $endDate)
            ->get();
    }

    public function getTrackCountPerTimeLastWeek()
    {
        // Set start and end date
        $startDate = Carbon::now()->startOfWeek()->subDays(7)->format('Y-m-d');
        $endDate   = Carbon::now()->endOfWeek()->subDays(7)->format('Y-m-d');

        // Set the starting hour of the day
        $startingTime = strtotime('00:00');

        // Create empty array to store tracks associated with time
        $trackTimes = [];

        // Loop through all the possible hours in a day
        for ($i = 0; $i < 24; $i++) {
            $endingTime = strtotime('+1 hour', $startingTime);
            $tracks     = $this->getByDatesAndTimes($startDate, $endDate, date('H:i', $startingTime), date('H:i', $endingTime));
            if (count($tracks) > 0) {
                foreach ($tracks as $track) {
                    $trackTimes[date('H:i', $startingTime)][] = $track;
                }
            } else {
                $trackTimes[date('H:i', $startingTime)] = [];
            }

            $startingTime = strtotime('+1 hour', $startingTime);
        }

        return $trackTimes;
    }

    public function getByDatesAndTimes($startDate, $endDate, $startingTime, $endingTime)
    {
        return PlayedTrack::select('*')
            ->where('played_date', '>=', $startDate)
            ->where('played_date', '<=', $endDate)
            ->where('time', '>=', $startingTime)
            ->where('time', '<=', $endingTime)
            ->get();
    }

    /**
     * Calculate the average plays based on a given timeframe
     *
     * @param string $timeFrame
     * @param string $startDate
     *
     * @return int
     */
    public function calculateAveragePlays($timeFrame, $startDate = null): int
    {
        $average = 0;

        switch ($timeFrame) {
            case 'total':

                $firstTrack = PlayedTrack::all()->first();

                $startDate = Carbon::parse($firstTrack->played_date . ' ' . $firstTrack->time);
                $endDate   = Carbon::now();

                $difference = $startDate->diffInDays($endDate);

                $average = (int) round(count($this->all()) / $difference);

                break;
            case 'yearly':

                break;
            case 'monthly':

                break;
            case 'daily':

                break;
        }

        return $average;
    }

    /**
     * Get the played tracks count based on a given timeFrame
     *
     * @param string $timeFrame
     * @param string $startDate
     */
    public function getPlayedTracksCount($timeFrame, $startDate = null)
    {
        switch ($timeFrame) {
            case 'yearly':

                # Get the first and last records to determine the start and end dates
                $first      = Carbon::parse(PlayedTrack::get()->first()->played_date);
                $last       = Carbon::parse(PlayedTrack::get()->last()->played_date);
                $difference = $first->diffInYears($last);

                $startDate = $first->startOfYear()->format('Y-m-d');
                $endDate   = $last->endOfYear()->format('Y-m-d');

                $trackYears = [];

                for ($i = 0; $i <= $difference; $i++) {
                    $endingDate = Carbon::parse($startDate)->endOfYear()->format('Y-m-d');
                    $tracks     = $this->getByDates($startDate, $endingDate);

                    if (count($tracks) > 0) {
                        foreach ($tracks as $track) {
                            $trackYears[date('Y', strtotime($startDate))][] = $track;
                        }
                    } else {
                        $trackYears[date('Y', strtotime($startDate))] = [];
                    }

                    $startDate = Carbon::parse($endingDate)->addDays(1)->format('Y-m-d');
                }

                break;
            case 'monthly':

                break;
            case 'daily':

                break;

        }

        return $trackYears;
    }

    /**
     * Get tracks based on start and end date
     *
     * @param string $startDate
     * @param string $endDate
     */
    public function getByDates($startDate, $endDate)
    {
        return PlayedTrack::select('*')
            ->where('played_date', '>=', $startDate)
            ->where('played_date', '<=', $endDate)
            ->get();
    }

    /**
     * Get the unique played tracks
     *
     * @param string $timeFrame
     * @param mixed  $paginatedResults
     */
    public function getUniquePlayedTracks($timeFrame, $paginatedResults = null)
    {
        $results = [];

        switch ($timeFrame) {
            case 'total':
                if (is_numeric($paginatedResults)) {
                    $results = PlayedTrack::select('*', DB::raw('COUNT(*) AS `total`'))
                        ->groupBy('track_id')
                        ->orderByRaw('COUNT(*) DESC')
                        ->paginate($paginatedResults);
                } else {
                    $results = PlayedTrack::select('*', DB::raw('COUNT(*) AS `total`'))
                        ->groupBy('track_id')
                        ->orderByRaw('COUNT(*) DESC')
                        ->get();
                }
                break;
        }

        return $results;
    }
}
