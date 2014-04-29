<!DOCTYPE html>
	<html lang="en">
		<head>
		<title>URL Shortener</title>
		{{HTML::style('/assets/css/style.css')}}
	</head>
		<body>
			<div id="container">
			<h2>Uber-Shortener</h2>
			@if(Session::has('message'))
			<h3 class="error">{{Session::get('message')}}</h3>
			@endif

			@if(Session::has('errors'))
				<h3 class="error">{{$errors->first('link')}}</h3>
			@endif

			@if(Session::has('link'))
				<h3 class="success">
				{{Html::link(Session::get('link'),'Click here for your 
				shortened URL')}}
				</h3>
			@endif
			{{Form::open(array('url'=>'/home'))}}
			{{Form::text('link',Input::old('link'),array('placeholder'=>'Insert your URL here and press enter!'))}}
			{{Form::close()}}

			

			

			
		</div>
	</body>
</html>