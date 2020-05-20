<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Game;

class MainController extends Controller
{

    protected $teams = ['Liverpool', 'Arsenal', 'Chelsea', 'Manchester City', ];

    public function home() {
        $teams = $this->teams;
        $league_token = Str::random(8);
        $fixture = $this->fixture();
        foreach ($fixture as $key => $value) {
            $game = new Game;
            $game->league_token = $league_token;
            $game->week_no = $key + 1;
            $game->home_team = $value[0][0];
            $game->away_team = $value[0][1];
            $game->save();

            $game = new Game;
            $game->league_token = $league_token;
            $game->week_no = $key + 1;
            $game->home_team = $value[1][0];
            $game->away_team = $value[1][1];
            $game->save();
        }

        return view('home', compact('teams', 'league_token'));
    }

    public function playAll() {
        $league_token = request()->get('league_token');
        $games = Game::where('league_token', $league_token)
            ->where('is_played', false)
            ->get();
        foreach ($games as $game) {
            $game->home_score = rand(0, 5);
            $game->away_score = rand(0, 5);
            $game->is_played = true;
            $game->save();
        }

        $prediction = [];
        $results = [];

        $games = Game::where('league_token', $league_token)->get();

        $ranking = $this->calculateRanking($games);
        foreach ($games as $game) {
            $results[] = [
                'home' => $this->teams[$game->home_team],
                'away' => $this->teams[$game->away_team],
                'score' => $game->home_score . ' - ' . $game->away_score,
            ];

            $prediction[] = [
                'home' => $this->teams[$game->home_team],
                'away' => $this->teams[$game->away_team],
                'score' => rand(0, 5) . ' - ' . rand(0, 5),
            ];
        }

        $data = [
            'week_no' => '-',
            'ranking' => $ranking,
            'results' => $results,
            'prediction' => $prediction,
        ];

        return response()->json($data, 200);
    }

    public function doNextMatch() {
        $week_no = request()->has('week_no') ? request()->get('week_no') : 1;
        $league_token = request()->get('league_token');
        if ($week_no > 6) {
            return 'The season has been end.';
        }
        $games = Game::where('league_token', $league_token)
            ->where('week_no', $week_no)
            ->get();

        $prediction = [];
        $results = [];
        foreach ($games as $game) {
            $game->home_score = rand(0, 5);
            $game->away_score = rand(0, 5);
            $game->is_played = true;
            $game->save();

            $results[] = [
                'home' => $this->teams[$game->home_team],
                'away' => $this->teams[$game->away_team],
                'score' => $game->home_score.' - '.$game->away_score,
            ];

            $prediction[] = [
                'home' => $this->teams[$game->home_team],
                'away' => $this->teams[$game->away_team],
                'score' => rand(0, 5).' - '.rand(0, 5),
            ];
        }

        $games = Game::where('league_token', $league_token)
            ->where('is_played', true)
            ->get();

        $ranking = $this->calculateRanking($games);

        $data = [
            'week_no' => $week_no,
            'ranking' => $ranking,
            'results' => $results,
            'prediction' => $prediction,
        ];

        return response()->json($data, 200);
    }
    
    protected function calculateRanking($games) {
        $ranking = [];
        for ($i = 0; $i < 4; $i++) {
            $ranking[$i] = [
                'team' => $this->teams[$i],
                'pts' => 0,
                'p' => 0,
                'w' => 0,
                'd' => 0,
                'l' => 0,
                'gd' => 0,
            ];
        }

        foreach ($games as $game) {
            $ranking[$game->home_team]['pts'] += $this->point($game->home_score, $game->away_score);
            $ranking[$game->home_team]['p'] += 1;
            $ranking[$game->home_team]['w'] += ($this->point($game->home_score, $game->away_score) == 3) ? 1 : 0;
            $ranking[$game->home_team]['d'] += ($this->point($game->home_score, $game->away_score) == 1) ? 1 : 0;
            $ranking[$game->home_team]['l'] += ($this->point($game->home_score, $game->away_score) == 0) ? 1 : 0;
            $ranking[$game->home_team]['gd'] += $game->home_score - $game->away_score;

            $ranking[$game->away_team]['pts'] += $this->point($game->away_score, $game->home_score);
            $ranking[$game->away_team]['p'] += 1;
            $ranking[$game->away_team]['w'] += ($this->point($game->away_score, $game->home_score) == 3) ? 1 : 0;
            $ranking[$game->away_team]['d'] += ($this->point($game->away_score, $game->home_score) == 1) ? 1 : 0;
            $ranking[$game->away_team]['l'] += ($this->point($game->away_score, $game->home_score) == 0) ? 1 : 0;
            $ranking[$game->away_team]['gd'] += $game->away_score - $game->home_score;
        }
        return $this->sortByPoint($ranking);
    }

    protected function sortByPoint($ranking) {
        for ($i = 0; $i < count($ranking); $i++) {
            for ($j = $i + 1; $j < count($ranking); $j++) {
                if (($ranking[$i]['pts'] < $ranking[$j]['pts'])
                    || ($ranking[$i]['pts'] == $ranking[$j]['pts'] && $ranking[$i]['gd'] < $ranking[$j]['gd'])) {
                    $temp = $ranking[$i];
                    $ranking[$i] = $ranking[$j];
                    $ranking[$j] = $temp;
                }
            }
        }
        return $ranking;
    }

    protected function point($my, $other) {
        if ($my > $other) {
            return 3;
        } else if ($my == $other) {
            return 1;
        }
        return 0;
    }

    protected function fixture() {
        return [
            [[0, 1, ], [2, 3, ], ],
            [[0, 2, ], [1, 3, ], ],
            [[0, 3, ], [1, 2, ], ],
            [[3, 1, ], [2, 0, ], ],
            [[2, 1, ], [3, 0, ], ],
            [[3, 2, ], [1, 0, ], ],
        ];
    }
}