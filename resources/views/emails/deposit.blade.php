<html>
<head><h3>CTG Drink Deposit</h3></head>
<body>
	Hi Stephanie,<br/>
	{{ $name }} has deposited {{ $deposit }} euros.<br/>
	Please check your account and confirm by clicking <a href="http://drinks.ctglab.nl/deposit/confirm/{{ $id }}">CONFIRM</a>.<br/>
	If you don't find the corresponding transaction, please decline by clicking <a href="http://drinks.ctglab.nl/deposit/cencel/{{ $id }}">DECLINE</a>.<br/>
	Thank you!!
</body>
