<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function index()
    {
        $generalStats = $this->statisticsService->getGeneralStatistics();
        $tasksByStatus = $this->statisticsService->getTasksByStatus();
        $completionTrend = $this->statisticsService->getTasksCompletionTrend();
        $topPerformers = $this->statisticsService->getTopPerformers();
        $partnerStats = $this->statisticsService->getPartnerStatistics();

        return view('statistics.index', compact(
            'generalStats',
            'tasksByStatus',
            'completionTrend',
            'topPerformers',
            'partnerStats'
        ));
    }
} 