<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DashboardInterface
{
    public function summary(Request $request): array;
}
