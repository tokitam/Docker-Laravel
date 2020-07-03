<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        //$logger = \Log::channel('daily')->getLogger();
        //$logger->info( "TEST LOG", ['file' => basename(__FILE__), 'line' => __LINE__] );

        \Log::debug('test');

        $rank = 0;
        $rank_r = 0;
        $prev_num = 999999999;

        foreach ($castings as $casting) {
            $row = [];
            foreach ($casting as $item) {
                // \Log::debug('$item:' . print_r($item, true), ['file' => basename(__FILE__), 'line' => __LINE__]);

                array_push($row, $item);
            }

            $rank_r++;

            \Log::debug('$prev_num:' . $request->get('from') . ':' . $prev_num);
            \Log::debug('$row[1]  :' . $request->get('from') . ':' . $row[1]);

            if ($prev_num > $row[1]) {
                $rank = $rank_r;
            }

            $prev_num = $row[1];


            array_unshift($row, $rank);
            array_push($list, $row);

        }

        return $list;
    }
}
