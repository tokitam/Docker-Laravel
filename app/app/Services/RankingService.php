<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingService
{
    public function getRanking(Request $request)
    {
        $castings = DB::table('castings')
            ->leftJoin('artists', 'artists.id', '=', 'castings.artist_id')
            ->leftJoin('episodes', 'episodes.id', '=', 'castings.episode_id')
            ->limit(20000)
            ->groupBy('castings.artist_id')
            ->orderBy('num_of', 'desc')
            ->select(DB::raw('artists.name, count(episodes.on_air_date) num_of'));

        if ($request->get('from')) {
            $castings->where('episodes.on_air_date', '>=',$request->get('from'));
        }
        if ($request->get('to')) {
            $castings->where('episodes.on_air_date', '<=',$request->get('to'));
        }
        $castings = $castings->get();

        $list = [];

        foreach ($castings as $casting) {
            $row = [];
            foreach ($casting as $item) {
                array_push($row, $item);
            }
            array_push($list, $row);
        }

        return $list;
    }
}
