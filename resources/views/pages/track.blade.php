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
		url: subdir+'/track/users',
		type: 'POST',
		error: function(){alert("error from users")},
		success: function(data){
			data.forEach(function(d){
				$('#member').append('<option value="'+d.vunetid+'">'+d.name+'</option>');
			})
		}
	})
	$.ajax({
		url: subdir+'/track/drinkType',
		type: 'POST',
		error: function(){alert("error from users")},
		success: function(data){
			data.forEach(function(d){
				$('#drink').append('<option value="'+d.id+'">'+d.type+' ('+d.cost+')'+'</option>');
			})
		}
	})
	$('#submit').on('click', function(){
		var drink = $('#drink option:selected').text();
		var n = $('#amount').val()
		if(n.length==0){
			bootbox.alert("Please fill all input fields.")
		}else{
			bootbox.confirm({
				message: "Please confirm your submission. <br/> Track "+n+" x "+drink,
				callback: function(res){
					if(res){
						$.ajax({
							url: subdir+"/track/recode",
							type: "POST",
							data: {
								id: $('#member').val(),
								drink: $('#drink').val(),
								amount: $('#amount').val()
							},
							error: function(){alert("error from recode track")},
							success: function(){
								$('#trackRes').html('<div class="w3-panel w3-pale-green">The drink(s) has been successfully recoded. Enjoy your drink!!</div>')
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
    	<h3>Track your drinks!!</h3>
		<div id="trackRes"></div>
		<label class="w3-text-blue">User:</label>
		<select class="w3-select w3-border" name="member" id="member">
		</select>
		<label class="w3-text-blue">Drink:</label>
		<select class="w3-select w3-border" name="drink" id="drink">
		</select>
		<label class="w3-text-blue">Amount:</label>
		<input class="w3-input w3-border" type="number" name="amount" id="amount">
		<br/>
		<button class="w3-btn w3-round w3-blue" id="submit">Submit</button>
	</div>
<div>
@stop
