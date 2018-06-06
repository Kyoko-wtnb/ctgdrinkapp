@extends('layout.master')
@section('header')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{!! URL::asset('js/bootbox.min.js') !!}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
$.ajaxSetup({
	headers: {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')}
});
var subdir = "{{ Config::get('app.subdir') }}";
$(document).ready(function(){
	$.ajax({
		url: subdir+'/deposit/users',
		type: 'POST',
		error: function(){alert("error from users")},
		success: function(data){
			data.forEach(function(d){
				$('#member').append('<option value="'+d.vunetid+'">'+d.name+'</option>');
			})
		}
	})
	$('#submit').on('click', function(){
		var n = $('#deposit').val()
		if(n.length==0){
			bootbox.alert("Please fill the amount you want to deposit.")
		}else{
			bootbox.confirm({
				message: "Are you sure you have already deposited "+n+" to Stephanie's account?",
				callback: function(res){
					if(res){
						$.ajax({
							url: subdir+"/deposit/recode",
							type: "POST",
							data: {
								id: $('#member').val(),
								deposit: $('#deposit').val()
							},
							error: function(){alert("error from recode deposit")},
							success: function(){
								$('#depositRes').html('<div class="w3-panel w3-pale-green">The deposit has been successfully recoded.</div>')
							}
						})
					}
				}
			})
		}
	})
});
</script>
@stop
@section('content')
<div class="w3-content">
	<div class="w3-container w3-center">
    	<h3>Deposite some money!!</h3>
		<div id="depositRes"></div>
		<label class="w3-text-blue">User:</label>
		<select class="w3-select w3-border" name="member" id="member">
		</select>
		<label class="w3-text-blue">Amount:</label>
		<input class="w3-input w3-border" type="number" name="deposit" id="deposit">
		<br/>
		<button class="w3-btn w3-round w3-blue" id="submit">Submit</button>
	</div>
<div>
@stop
