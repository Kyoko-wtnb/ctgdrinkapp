<div class="w3-padding-32">
	<div class="w3-bar w3-border w3-round w3-padding-5 w3-white w3-opacity">
		<a href="{{ Config::get('app.subdir') }}/" class="w3-bar-item w3-button {{ Request::is('/') ? 'active' : ''}}">Home</a>
		<a href="{{ Config::get('app.subdir') }}/track" class="w3-bar-item w3-button {{ Request::is('/track') ? 'active' : ''}}">Track drinks</a>
		<a href="{{ Config::get('app.subdir') }}/deposit" class="w3-bar-item w3-button {{ Request::is('/deposit') ? 'active' : ''}}">Deposit</a>
		<a href="{{ Config::get('app.subdir') }}/balance" class="w3-bar-item w3-button {{ Request::is('/balance') ? 'active' : ''}}">Balance</a>
	</div>
</div>
