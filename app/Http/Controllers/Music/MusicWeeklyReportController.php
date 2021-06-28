<?php

namespace App\Http\Controllers\Music;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

use App\Services\Music\MusicService;
use App\Services\Music\PlayedTrackService;
use App\Repositories\Music\PlayedTrackRepositoryInterface;

class MusicWeeklyReportController extends Controller
{
    private $musicService;
    private $playedTrackService;
    private $playedTrackRepository;

    /**
     * Constructor
     */
    public function __construct(PlayedTrackRepositoryInterface $playedTrackRepository)
    {
        $this->middleware('auth');

        $this->musicService       = new musicService;
        $this->playedTrackService = new PlayedTrackService;

        $this->playedTrackRepository = $playedTrackRepository;
    }

    /**
     * Show weekly report view
     */
    public function index(): View
    {
        $startDate = $this->musicService->getStartDateForReport('weekly');
        $endDate   = $this->musicService->getEndDateForReport('weekly');

        $data = [
            'title'              => 'Weekly Report',
            'startDateFormatted' => Carbon::parse($startDate)->toFormattedDateString(),
            'endDateFormatted'   => Carbon::parse($endDate)->toFormattedDateString(),
            'weeklyReportData'   => $this->musicService->generateListeningReport($startDate, $endDate),
            'totalPlayedTracks'  => $this->playedTrackRepository->getWeekly($startDate, $endDate),
            'totalListeningTime' => $this->playedTrackRepository->calculateListeningTime('last-week', true),
            'totalPlayedTracksLastWeek' => $this->playedTrackRepository->getWeekly(Carbon::parse($startDate)->subDays(7), Carbon::parse($endDate)->subDays(7)),
            'totalListeningTimeLastWeek' => $this->playedTrackRepository->calculateListeningTime('-2 week', true),
            'trackCountPerTimeLastWeek' => $this->playedTrackRepository->getTrackCountPerTimeLastWeek(),
        ];

        return view('music.reports.weekly')->with($data);
    }
}
