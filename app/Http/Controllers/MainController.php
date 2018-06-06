<?php

namespace ctgdrinkapp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ctgdrinkapp\Http\Requests;
use Mail;

class MainController extends Controller
{
    public function Activities(){
		$results = DB::select('SELECT date, min(time) as time, sum(amount) as N FROM drinks GROUP BY date ORDER BY date DESC LIMIT 5');
		return $results;
	}

	public function Users(){
		$results = DB::select('SELECT vunetid, name FROM members');
		return $results;
	}

	public function DrinkType(){
		$results = DB::select('SELECT * FROM drink_type');
		return $results;
	}

	public function drinkRecode(Request $request){
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$vunetid = $request->input('id');
		$drinkid = $request->input('drink');
		$amount = $request->input('amount');
		$drink = collect(DB::select('SELECT * FROM drink_type WHERE id=?', [$drinkid]))->first();
		$cost = $amount * $drink->cost;
		DB::table('drinks')->insert(
			['vunetid'=>$vunetid, 'type'=>$drink->type, 'amount'=>$amount,
			'cost'=>$cost, 'date'=>$date, 'time'=>$time]
		);
		return;
	}

	public function depositRecode(Request $request){
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$vunetid = $request->input('id');
		$deposit = $request->input('deposit');
		DB::table('deposits')->insert(
			['vunetid'=>$vunetid, 'deposit'=>$deposit,
			'status'=>"PENDING", 'date'=>$date, 'time'=>$time]
		);
		$depoid = DB::table('deposits')->where('vunetid', $vunetid)->where('date', $date)->where('time', $time)->first()->id;
		$name = DB::table('members')->where('vunetid', $vunetid)->first()->name;
		$data = [
			'id'=>$depoid,
			'name'=>$name,
			'deposit'=>$deposit
		];
		$devemail = config('app.devemail');
		$depositemail = config('app.depositemail');
		Mail::send('emails.deposit', $data, function($m) use($devemail, $depositemail){
			$m->from($devemail, "CTG Drink Tracker");
			$m->to($depositemail)->subject("CTG Drink Deposit");
		});
		return;
	}

	public function Confirm($id){
		DB::table('deposits')->where('id', $id)->update(['status'=>'APPROVED']);
		return view('pages.confirm');
	}

	public function getData(){
		$results = DB::select('SELECT id, name, (depo-cost) AS balance, last, pend FROM (SELECT vunetid AS id, sum(cost) AS cost, max(date) AS last FROM drinks GROUP BY vunetid) LEFT JOIN (SELECT id1 AS id3, depo, pend FROM (SELECT vunetid AS id1, sum(deposit) AS depo FROM deposits WHERE status="APPROVED" GROUP BY vunetid) LEFT JOIN (SELECT vunetid AS id2, sum(deposit) AS pend from deposits WHERE status="PENDING" GROUP BY vunetid) ON id1=id2) ON vunetid = id3 INNER JOIN members on id=vunetid');
		return $results;
	}
}
