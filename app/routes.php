<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('form');
});



Route::post('/home',function(){
//We first define the Form validation rule(s)
$rules = array(
'link' => 'required|url'
);
//Then we run the form validation
$validation = Validator::make(Input::all(),$rules);
//If validation fails, we return to the main page with an error info
if($validation->fails()) {
	return Redirect::to('/')
		->withInput()
		->withErrors($validation);
} else {
//Now let's check if we already have the link in our database. If so, we get the first result
$link = Link::where('url','=',Input::get('link'))->first();
//If we have the URL saved in our database already, we provide that information back to view.
if($link) {
return Redirect::to('/')
	->withInput()
	->with('link',$link->hash);
//Else we create a new unique URL
} else {
//First we create a new unique Hash
do {
$newHash = Str::random(6);
} while(Link::where('hash','=',$newHash)->count() > 0);
//Now we create a new database record
Link::create(array(
'url' => Input::get('link'),
'hash' => $newHash
));
//And then we return the new shortened URL info to our action
return Redirect::to('/')
	->withInput()
	->with('link',$newHash);
}
}
});

Route::get('{hash}',function($hash) {
//First we check if the hash is from a URL from our database
$link = Link::where('hash','=',$hash)->first();
//If found, we redirect to the URL
if($link) {
return Redirect::to($link->url);
//If not found, we redirect to index page with error message
} else {
	return Redirect::to('/')
		->with('message','Invalid Link');
}
})->where('hash', '[0-9a-zA-Z]{6}');