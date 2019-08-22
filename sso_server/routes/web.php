<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\MySSOServer;
use Illuminate\Http\Request;

Route::get('/', function (MySSOServer $ssoServer, Request $request) {
    $command = $request->has('command') ? $request->get('command') : null;
    
    if (!$command || !method_exists($ssoServer, $command)) {
        header('HTTP/1.1 404 Not Found');
        header('Content-type: application/json; charset=UTF-8');
        
        return response()->json(['error' => 'Unknown command']);
    }

    $user = $ssoServer->$command();

    if ($user) {
        return response()->json($user);
    }
});

Route::post('/', function (MySSOServer $ssoServer, Request $request) {

    $command = $request->has('command') ? $request->get('command') : null;


    if (!$command || !method_exists($ssoServer, $command)) {
        header('HTTP/1.1 404 Not Found');
        header('Content-type: application/json; charset=UTF-8');

        return response()->json(['error' => 'Unknown command']);
    }

    

    $user = $ssoServer->$command();

    if ($user) {
        return response()->json($user);
    }
});
