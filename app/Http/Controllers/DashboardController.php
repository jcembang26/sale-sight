<?php

namespace App\Http\Controllers;

use App\Interfaces\DashboardInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * fetch data using dashboard services
     *
     * @param DashboardInterface $dashboardInterface
     * @param Request $request
     * @return array
     */
    public function summary(DashboardInterface $dashboardInterface, Request $request): array
    {
        return $dashboardInterface->summary($request);
    }
}
