<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;

class RankingController extends Controller
{

    public function index(Request $request)
    {
        $castingsService = new \App\Services\RankingService();
        return ['data' => $castingsService->getRanking($request)];
    }

    public function store()
    {
        return '{"w": 1}';
    }

    public function show()
    {
        return '{"w": 2}';
    }

    public function update()
    {
        return '{"w": 3}';
    }

    public function destroy()
    {
        return '{"w": 4}';
    }

    public function ranking()
    {
        return '{"num_of": 123}';
    }
}
