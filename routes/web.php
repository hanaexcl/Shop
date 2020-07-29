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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test2', function () {
    $temp = \App\test::find(1);

    $number =  $temp->num;
    $number--;

    $temp->num = $number;
    $temp->save();

    return $number;
});

Route::get('/test1', function () {
    $temp = \App\test::find(1);
    return $temp->num;
});

Route::get('/test3', function () {

    DB::beginTransaction();

    try {

        $temp = \App\test::lockForUpdate()->find(1);

        $number =  $temp->num;
        $number--;

        $temp->num = $number;
        $temp->save();
    } catch (\Exception $e) {
        DB::rollback();
        throw new HttpException(500, $e->getMessage(), $e, [], 0);
    }

    DB::commit();

    return $number;
});

Route::get('/test4', function () {


//    return DB::transaction(function()
//    {
//        $temp = \App\test::find(1);
//
//        $number =  $temp->num;
//        $number--;
//
//        $temp->num = $number;
//        $temp->save();
//
//        return $number;
//    });

    DB::transaction(function()
    {
        DB::table('tests')->update(array('num' => 'num' - 1));
    });

    //return 'error';
});
