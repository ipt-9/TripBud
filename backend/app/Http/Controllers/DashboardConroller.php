<?php

namespace App\Http\Controllers;

class DashboardConroller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the dashboard!',
            'data' => [
                'user_info' => auth()->user(),
            ]
        ]);
    }
}
