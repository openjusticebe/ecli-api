<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Document;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Carbon\Carbon;
use DB;

class findDuplicates extends Command
{
    protected $signature = 'bots:findDuplicates';
    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'This command will find duplicates and delete all the +1 occurences.';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $duplicates = Document::select('identifier', 'court_id', 'type', 'year', DB::raw('COUNT(*) as `occurences`'))
        ->groupBy('identifier', 'court_id', 'type', 'year')
        ->having('occurences', '>', '1')
        ->orderBy('identifier')
        ->get();

        foreach ($duplicates as $duplicate) {
            $dontDeleteThis = Document::where('identifier', $duplicate->identifier)
            ->where('year', $duplicate->year)
            ->where('type', $duplicate->type)
            ->where('court_id', $duplicate->court_id)
            ->first();

            $toDeletes = Document::where('identifier', $duplicate->identifier)
            ->where('year', $duplicate->year)
            ->where('type', $duplicate->type)
            ->where('court_id', $duplicate->court_id)
            ->where('id', '!=', $dontDeleteThis->id)
            ->delete();
            
            $this->line($duplicate->ecli . '<fg=blue> Occurences found of ECLI [' . $duplicate->occurences . ']</><fg=red> Deleted occurence [' . ($duplicate->occurences - 1) . ']</>');
        }
    }
}
