<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DashboardInterface
{
    /**
     * Collect insights for dashboard
     *
     * @param Request $request
     * @return array
     */
    public function summary(Request $request): array;
}
