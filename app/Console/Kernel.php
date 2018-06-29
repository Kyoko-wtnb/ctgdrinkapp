<?php

namespace ctgdrinkapp\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use fuma\Http\Controllers\Controller;
use DB;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
		$schedule->call(function(){
			$devemail = config('app.devemail');
			$rows = DB::select('SELECT vunetid, name, email, total FROM members LEFT JOIN (SELECT id0, SUM(total) AS total FROM (SELECT vunetid AS id0, -1*SUM(cost) AS total FROM drinks GROUP BY vunetid UNION ALL SELECT vunetid AS id0, SUM(deposit) AS total FROM deposits WHERE status!="CANCELLED" GROUP BY vunetid) GROUP BY id0) ON vunetid=id0 WHERE total<0');
			foreach($rows as $row){
				$data = [
	              'name'=>$row->name,
	              'total'=>$row->total
	            ];
				Mail::send('emails.NegativeDeposit', $data, function($m) use($devemail, $row){
	              $m->from($devemail, "CTG Drink Tracker");
	              $m->to($row->email, $row->name)->subject("CTG Drink Tracker: Negative balance");
	            });
			}
		});
    }
}
