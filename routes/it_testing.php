<?php

Route::get('/login', function () {
    Auth::login(\App\Models\User::factory()->create());
});
Route::get('/products', function () {
   echo "success";
});

Route::get('/create', function () {
    $modelClass = 'App\Models\\' . request('model');
    return $modelClass::factory()->create();
});