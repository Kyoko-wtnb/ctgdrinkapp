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
			data = JSON.parse(data)
			data.data.forEach(function(d){
				if(d[2]<0){
					$('#balanceTable').append('<tr><td><a onclick="indiv_drinks('+"'"+d[0]+"','"+d[1]+"'"+');">'+d[1]+'</a></td><td style="color:blue;"><b>'+d[2]+'</b></td><td>'+d[3]+'</td><td>'+d[4]+'</td></tr>')
				}else{
					$('#balanceTable').append('<tr><td><a onclick="indiv_drinks('+"'"+d[0]+"','"+d[1]+"'"+');">'+d[1]+'</a></td><td>'+d[2]+'</td><td>'+d[3]+'</td><td>'+d[4]+'</td></tr>')
				}
			})
		}
	})
})
function indiv_drinks(vunetid, name){
	$.ajax({
		url: subdir+'/balance/getIndivDrinks',
		type: 'POST',
		data: {"id": vunetid},
		error: function(){alert("error from getIndivDrinks")},
		success: function(data){
			$('#modal').modal('show');
			$('#head').html("Last 10 drinks of "+name);
			$('#DrinkTable_body').html("");
			data.forEach(function(d){
				$('#DrinkTable_body').append('<tr><td>'+d.date+'</td><td>'+d.time+'</td><td>'+d.type+'</td><td>'+d.amount+'</td><td>'+d.cost+'</td></tr>');
			})
		}
	});
}
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

<!-- Modal recent drink -->
<div class="modal fade" id="modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header"><h4><strong id="head"></strong></h4></div>
			<div class="modal-body">
				<table class="w3-table w3-bordered" id="DrinkTable">
					<thead>
						<tr>
							<th>Date</th>
							<th>Time</th>
							<th>Drink</th>
							<th>Amount</th>
							<th>Cost</th>
						</tr>
					</thead>
					<tbody id="DrinkTable_body">
					</tbory>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
