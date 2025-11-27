<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $data = array(
        "status"    => true,
        "pesan"     => "API INI HANYA UNTUK TEST PT Cipta Koin Digital !"
    );
});
