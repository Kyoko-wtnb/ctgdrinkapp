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
		url: subdir+'/balance/getData',
		type: 'POST',
		error: function(){alert("error from getData")},
		success: function(data){
			data.forEach(function(d){
				if(d.balance<0){
					$('#balanceTable').append('<tr><td>'+d.name+'</td><td style="color:blue;"><b>'+d.balance+'</b></td><td>'+d.pend+'</td><td>'+d.last+'</td></tr>')
				}else{
					$('#balanceTable').append('<tr><td>'+d.name+'</td><td>'+d.balance+'</td><td>'+d.pend+'</td><td>'+d.last+'</td></tr>')
				}
			})
		}
	})
})
</script>
@stop
@section('content')
<div class="w3-content">
	<div class="w3-container w3-center">
		<h3>Check your balance!!</h3>
		<table class="w3-table w3-bordered" id="balanceTable">
			<tr>
				<th>Name</th>
				<th>Balance</th>
				<th>Pending deposit</th>
				<th>Last drink</th>
			</tr>
		</table>
	</div>
<div>
@stop
