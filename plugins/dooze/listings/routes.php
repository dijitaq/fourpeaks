<?php
Route::get('/listings/update', 'Dooze\Listings\Http\Controllers\JobController@update')->middleware('web');