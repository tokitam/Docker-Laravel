<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services;

class CastingsController extends Controller
{

    public function index()
    {
        $castingsService = new \App\Services\CastingsService();
        return ['data' => $castingsService->getCastings()];
    }

    public function store()
    {
        return '{}';
    }

    public function show()
    {
        return '{}';
    }

    public function update()
    {
        return '{}';
    }

    public function destroy()
    {
        return '{}';
    }
}
