<?php

use Illuminate\Database\Seeder;
use App\models\Episode;
use App\models\Artist;
use App\models\Casting;

class ImportSeeder extends Seeder
{
    var $data_dir;
    var $artists;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //echo "This is ImportSeeder.\n";
        $this->data_dir = base_path('database/seeds/original_data/');
        $files = $this->getFiles($this->data_dir);
        sort($files);
        //var_dump($files);

        foreach ($files as $file) {
            $this->import($file);
            //break;
        }
    }

    public function getFiles($dir)
    {
        $files = [];

        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $files[] = $file;
            }
            closedir($dh);
        }

        return $files;
    }

    public function import($file)
    {
        $file = $this->data_dir . $file;
        //echo "file : " . $file . "\n";
        if (!is_readable($file)) {
            return;
        }

        $data = file_get_contents($file);

        $json = json_decode($data, true);
        //var_dump($json);

        if (empty($json['date'])) {
            //throw new Exception('Import data illegal: date empty : ' . $file);
            return;
        }

        if (!preg_match('/^([0-9]{4})\.([0-9]{2})\.([0-9]{2})/', $json['date'], $r)) {
            throw new Exception('Import data illegal: date format : ' . $file);
        }

        //echo __FILE__ . ':' . __LINE__ . "\n";
        //var_dump($r);

        $year = intval($r[1]);
        $month = intval($r[2]);
        $day = intval($r[3]);
        $date = sprintf('%04d-%02d-%02d', $year, $month, $day);

        $episode = Episode::where('on_air_date', $date)->first();
        //echo __FILE__ . ':' . __LINE__ . "\n";
//var_dump($episode);
        if (empty($episode)) {
            $episode = new Episode();
            $episode->on_air_date = sprintf('%d-%d-%d', $year, $month, $day);
            $episode->save();
        //} else {
        //    $episode = $episode->pop();
        }

        if (empty($json['data'])) {
            throw new Exception('Import data illegal: data emtpy : ' . $file);
        }
        //echo __FILE__ . ':' . __LINE__ . "\n";
//var_dump($json);
        foreach ($json['data'] as $item) {
            if (empty($item)) {
                break;
            }

            //echo __FILE__ . ':' . __LINE__ . "\n";
            //var_dump($item);

            if (empty($item['artists_name_disp'])) {
                return;
            }

            $artist = Artist::where('name', $item['artists_name_disp'])->first();

            if (empty($artist)) {
                //echo __FILE__ . ':' . __LINE__ . "\n";
                //var_dump($item);
                $artist = new Artist();
                $artist->name = $item['artists_name_disp'];
                $artist->save();
                $this->artists[$item['artists_name_disp']] = 1;
            }

            $query = Casting::query();
            $query->where('episode_id', $episode->id);
            $query->where('artist_id',  $artist->id);
            $query->where('song_title', $item['music_name_disp']);
            $casting = $query->first();

            if (empty($casting)) {
                //echo __FILE__ . ':' . __LINE__ . "\n";
                $casting = new Casting();
                //echo __FILE__ . ':' . __LINE__ . "\n";
                $casting->song_title = $item['music_name_disp'];
                //echo __FILE__ . ':' . __LINE__ . "\n";
                $casting->episode_id = $episode->id;
                //echo __FILE__ . ':' . __LINE__ . "\n";
                $casting->artist_id = $artist->id;
                //echo __FILE__ . ':' . __LINE__ . "\n";
                $casting->save();
                //echo __FILE__ . ':' . __LINE__ . "\n";
            }
        }
    }
}
