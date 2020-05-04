<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CastingsService
{
    public function getCastings()
    {
        $castings = DB::table('castings')
            ->leftJoin('artists', 'artists.id', '=', 'castings.artist_id')
            ->leftJoin('episodes', 'episodes.id', '=', 'castings.episode_id')
            ->limit(20000)
            //->limit(1000)
            ->select(['episodes.on_air_date', 'artists.name', 'castings.song_title'])
            ->get();

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
