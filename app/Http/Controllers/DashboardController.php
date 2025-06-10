<?php

namespace App\Http\Controllers;

use App\Interfaces\DashboardInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function summary(DashboardInterface $dashboardInterface, Request $request): array
    {
        return $dashboardInterface->summary($request);
    }
}
