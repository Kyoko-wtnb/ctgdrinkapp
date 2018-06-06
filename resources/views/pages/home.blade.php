@extends('layout.master')
@section('header')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
$.ajaxSetup({
	headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')}
});
var subdir = "{{ Config::get('app.subdir') }}";
$(document).ready(function(){
	$.ajax({
		url: subdir+'/activities',
		type: 'POST',
		error: function(){alert("error from activities")},
		success: function(data){
			if(data.length==0){
				$('#activities').html("No activity has been recorded yet.");
			}else{
				data.forEach(function(d){
					$('#activities').append(d.date+" "+d.time+" "+d.N+" drinks<br/>");
				})
			}
		}
	})
});
</script>
@stop
@section('content')
<div class="w3-content">
	<div class="w3-container w3-center">
    	<h3>Welcome to the CTG drink tracker</h3>
		<p style="font-size:18px;">
			<i class="fa fa-beer"></i> When you are having drinks,
			don't forget to track at <a href="{{ Config::get('app.subdir') }}/track">Track drink</a> page.
			<br/>
			<i class="fa fa-coins"></i> You can claim your deposite at <a href="{{ Config::get('app.subdir') }}/deposit">Deposit</a> page.
			Please do that only after transfered money to the Stephanie's bank account.
			<br/>
			<i class="fa fa-piggy-bank"></i> And check your balance at <a href="{{ Config::get('app.subdir') }}/balance">Balance</a> page.
			<br/>
			Enjoy your drinks <i class="far fa-smile"></i>
		</p>
		<p>
			If you don't have your account, please send an email to Kyoko.
		</p>
		<div class="w3-panel w3-border">
			<h4>Recent activity</h4>
			<div id="activities">
			</div>
		</div>

	</div>
<div>
@stop
