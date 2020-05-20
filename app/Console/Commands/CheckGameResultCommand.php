<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckGameResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:game-result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $drainA = $this->ask('Enter A Teams players (enter drain by separating comma):');
        $drainB = $this->ask('Enter B Teams players (enter drain by separating comma):');

        $teamA = explode(',', str_replace(' ', '', $drainA));
        $teamB = explode(',', str_replace(' ', '', $drainB));

        if (count($teamA) != count($teamB)) {
            echo "Number of 2 team players are not same.";
            exit;
        }

        $teamA = $this->sortByAsc($teamA);
        $teamB = $this->sortByAsc($teamB);
        foreach ($teamA as $key => $value) {
            if ($teamA[$key] < $teamB[$key]) {
                echo "Lose";
                exit;
            }
        }
        echo "Win";
    }

    public function sortByAsc($arr) {
        for ($i = 0; $i < count($arr); $i++) {
            for ($j = $i + 1; $j < count($arr); $j++) {
                if ($arr[$i] > $arr[$j]) {
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }
}
