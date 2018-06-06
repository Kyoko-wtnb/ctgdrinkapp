<!DOCTYPE html>
<html lang="en">
<head>
	@include('includes.head')

</head>

<body>
	<header class="bgimg w3-display-container w3-center" style="padding-top:60px; padding-bottom:60px;">
		<h1 class="w3-xlarge">Complex Trait Genetics</h1>
		<h1>Friday Drink Tracker</h1>
		@include('includes.header')
		@yield('header')
	</header>
	<div class="w3-container">
		@yield('content')
	</div>
</body>
</html>
