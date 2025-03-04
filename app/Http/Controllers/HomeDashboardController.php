<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeDashboardController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/HomeDashboard',

        );
    }
}
