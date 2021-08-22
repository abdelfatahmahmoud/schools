<?php

use Illuminate\Support\Facades\Route;

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
Auth::routes();

route::group(['middleware'=>['guest']],function (){

    Route::get('/', function()
    {
        return view('auth.login');
    });
});




Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth' ]
    ], function(){

    //****************************start dashboard***************
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    route::group(['namespace'=>'Grades'],function () {
        Route::resource('Grades', 'GradeController');
    });
    //****************************end dashboard***************

    //****************************start Classroom***************
    route::group(['namespace'=>'Classroom'],function () {
    Route::resource('classroom', 'ClassroomController');
        Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');
        Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
});

    //****************************end Classroom***************

    //****************************start section***************

    Route::group(['namespace' => 'Sections'], function () {

        Route::resource('Sections', 'SectionController');

        Route::get('/classes/{id}', 'SectionController@getclasses');

    });

    //****************************end section***************

    Route::view('add_parent','livewire.show_Form');


    //==============================Teachers============================
    Route::group(['namespace' => 'Teacher'], function () {
        Route::resource('Teachers', 'TeacherController');
    });

    //==============================Teachers============================
    Route::group(['namespace' => 'Student'], function () {
        Route::resource('Student', 'StudentController');
        Route::get('/Get_classrooms/{id}', 'StudentController@Get_classrooms');
        Route::get('/Get_Sections/{id}', 'StudentController@Get_Sections');
        Route::post('Upload_attachment', 'StudentController@Upload_attachment')->name('Upload_attachment');
        Route::get('Download_attachment/{studentsname}/{filename}', 'StudentController@Download_attachment')->name('Download_attachment');
        Route::post('Delete_attachment', 'StudentController@Delete_attachment')->name('Delete_attachment');
        Route::post('Graduated_one', 'StudentController@Graduated')->name('Graduated_one');

    });


    //==============================Promotion Students ============================
    Route::group(['namespace' => 'Student'], function () {
        Route::resource('Promotion', 'PromotionController');
        Route::post('Graduated_promotion', 'PromotionController@Graduated_promotion')->name('Graduated_promotion');

    });
    //==============================graduated Students ============================
    Route::group(['namespace' => 'Student'], function () {
        Route::resource('Graduated', 'GraduatedController');
    });



});






