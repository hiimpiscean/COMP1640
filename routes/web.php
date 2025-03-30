<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;
use App\Repository\ProductRepos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ManualAuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GoogleMeetController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\LearningMaterialsController;

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

//Route::get('/', function () {
//   return view('welcome');
//});

//Route::get('blade', function () {
//  return view('viewEngine');
//});

//////////////Staff/////////////
// Routes dành cho sinh viên
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Auth::routes();

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // Course registration routes
    Route::get('/courses/{course}/register', [StudentRegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/courses/{course}/register', [StudentRegistrationController::class, 'store'])->name('registrations.store');
    Route::get('/registrations', [StudentRegistrationController::class, 'index'])->name('registrations.index');
    
    // View courses
    Route::get('/courses', [App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{course}', [App\Http\Controllers\Student\CourseController::class, 'show'])->name('courses.show');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    // Registration management
    Route::get('/registrations', [StaffRegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/{registration}', [StaffRegistrationController::class, 'show'])->name('registrations.show');
    Route::post('/registrations/{registration}/approve', [StaffRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{registration}/reject', [StaffRegistrationController::class, 'reject'])->name('registrations.reject');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/courses', [App\Http\Controllers\Teacher\CourseController::class, 'index'])->name('courses');
    Route::get('/courses/{course}', [App\Http\Controllers\Teacher\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/students', [App\Http\Controllers\Teacher\CourseController::class, 'students'])->name('courses.students');
});

// Dashboard
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// mail router từ đây lên trên 

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/student/register', [StudentRegistrationController::class, 'register'])->name('student.register');
    Route::post('/student/confirm-assignment/{id}', [StudentRegistrationController::class, 'confirmAssignment'])->name('student.confirm-assignment');
});

// Routes dành cho nhân viên
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/registrations', [StaffController::class, 'viewRegistrations'])->name('staff.registrations');
    Route::post('/staff/assign-class/{id}', [StaffController::class, 'assignClass'])->name('staff.assign-class');
});

Route::group(['prefix' => 'staff', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'StaffController@index',
        'as' => 'staff.index'
    ]);

    Route::get('show/{id_s}', [
        'uses' => 'StaffController@show',
        'as' => 'staff.show'
    ]);

    Route::get('create', [
        'uses' => 'StaffController@create',
        'as' => 'staff.create'
    ]);

    Route::post('create', [
        'uses' => 'StaffController@store',
        'as' => 'staff.store'
    ]);

    Route::get('update/{id_s}', [
        'uses' => 'StaffController@edit',
        'as' => 'staff.edit'
    ]);

    Route::put('update/{id_s}', [
        'uses' => 'StaffController@update',
        'as' => 'staff.update'
    ]);

    Route::get('delete/{id_s}', [
        'uses' => 'StaffController@confirm',
        'as' => 'staff.confirm'
    ]);

    Route::DELETE('delete/{id_s}', [
        'uses' => 'StaffController@destroy',
        'as' => 'staff.destroy'
    ]);

    Route::get('/classroom', [ClassroomController::class, 'index'])->name('classroom.index');
    Route::get('/classroom/create', [ClassroomController::class, 'create'])->name('classroom.create');
    Route::post('/classroom', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::get('/classroom/{id}', [ClassroomController::class, 'show'])->name('classroom.show');
});

//////////////Teacher/////////////
Route::group(['prefix' => 'teacher', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'TeacherController@index',
        'as' => 'teacher.index'
    ]);

    Route::get('show/{id_t}', [
        'uses' => 'TeacherController@show',
        'as' => 'teacher.show'
    ]);

    Route::get('create', [
        'uses' => 'TeacherController@create',
        'as' => 'teacher.create'
    ]);

    Route::post('create', [
        'uses' => 'TeacherController@store',
        'as' => 'teacher.store'
    ]);

    Route::get('update/{id_t}', [
        'uses' => 'TeacherController@edit',
        'as' => 'teacher.edit'
    ]);

    Route::put('update/{id_t}', [
        'uses' => 'TeacherController@update',
        'as' => 'teacher.update'
    ]);

    Route::get('delete/{id_t}', [
        'uses' => 'TeacherController@confirm',
        'as' => 'teacher.confirm'
    ]);

    Route::DELETE('delete/{id_t}', [
        'uses' => 'TeacherController@destroy',
        'as' => 'teacher.destroy'
    ]);
});

//////////////client////////////
Route::get('/', [
    'uses' => 'HomepageController@home',
    'as' => 'ui.index'
]);

Route::get('/team', function () {
    return view('ui.team');
})->name('ui.team');

Route::get('/testimonial', function () {
    return view('ui.testimonial');
})->name('ui.testimonial');

Route::get('/schedule', function () {
    return view('ui.schedule');
})->middleware('manual.auth')->name('ui.schedule');

Route::get('/listDocument', function () {
    return view('flm.listDocument');
})->name('flm.listDocument');

Route::get('/approval', function () {
    return view('ui.approval');
})->middleware('manual.auth')->name('ui.approval');

//Route::middleware(['auth', 'role:teacher'])->group(function () {
//    Route::get('/teacher/pending', [TeacherController::class, 'pendingRegistrations'])->name('teacher.pending');
//    Route::post('/teacher/approve/{id}', [TeacherController::class, 'approveRegistration'])->name('teacher.approve');
//    Route::post('/teacher/reject/{id}', [TeacherController::class, 'rejectRegistration'])->name('teacher.reject');
//});

Route::group(['middleware' => 'manual.auth'], function () {
    Route::get('/curriculum', [ProductController::class, 'curriculumGeneral'])
        ->name('flm.curriculum');

    Route::get('/curriculum/{productName?}', [ProductController::class, 'curriculum'])
        ->name('curriculum');
});

Route::group(['prefix' => 'home'], function () {

    Route::get('product', [
        'uses' => 'HomepageController@index',
        'as' => 'ui.home'
    ]);
    // home

    Route::get('category/{id_cate}', [
        'uses' => 'HomepageController@getproductsfromcate',
        'as' => 'ui.showproducts'
    ]);
    //details

    Route::get('details/{id_p?}', [
        'uses' => 'HomepageController@showdetails',
        'as' => 'ui.details'
    ]);
    Route::get('show/{id_p}', [
        'uses' => 'HomepageController@show',
        'as' => 'ui.show'
    ]);

    Route::get('create', [
        'uses' => 'HomepageController@create',
        'as' => 'ui.create'
    ]);

    Route::post('create', [
        'uses' => 'HomepageController@storecustomer',
        'as' => 'ui.store'
    ]);

    Route::get('update/{id_p}', [
        'uses' => 'HomepageController@edit',
        'as' => 'ui.edit'
    ]);

    Route::post('update/{id_p}', [
        'uses' => 'HomepageController@update',
        'as' => 'ui.update'
    ]);

    Route::get('search/', [
        'uses' => 'HomepageController@search',
        'as' => 'ui.search'
    ]);
    Route::get('thanks', function () {
        return view('ui.thankyou');
    })->name('ui.thank');
});
////////////////Login Admin ////////////////////////////////////
///
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [
        'uses' => 'ManualAuthController@ask',
        'as' => 'auth.ask'
    ]);

    Route::post('login', [
        'uses' => 'ManualAuthController@signin',
        'as' => 'auth.signin'
    ]);

    Route::get('logout', [
        'uses' => 'ManualAuthController@signout',
        'as' => 'auth.signout'
    ]);
});

// Các route cho khách xem blog không cần đăng nhập
Route::group(['prefix' => 'blog'], function () {
    Route::get('', [
        'uses' => 'BlogController@index',
        'as' => 'blog.index'
    ]);

    Route::get('show/{id}', [
        'uses' => 'BlogController@show',
        'as' => 'blog.show'
    ]);
});

// Các route chỉ dành cho người đã đăng nhập
Route::group(['prefix' => 'blog', 'middleware' => ['manual.auth']], function () {
    Route::get('create', [
        'uses' => 'BlogController@create',
        'as' => 'blog.create'
    ]);

    Route::post('create', [
        'uses' => 'BlogController@store',
        'as' => 'blog.store'
    ]);

    Route::get('update/{id}', [
        'uses' => 'BlogController@edit',
        'as' => 'blog.edit'
    ]);

    Route::post('update/{id}', [
        'uses' => 'BlogController@update',
        'as' => 'blog.update'
    ]);

    Route::get('delete/{id}', [
        'uses' => 'BlogController@confirm',
        'as' => 'blog.confirm'
    ]);

    Route::post('delete/{id}', [
        'uses' => 'BlogController@destroy',
        'as' => 'blog.destroy'
    ]);

    // Route cho bình luận
    Route::post('{id}/comment', [
        BlogController::class,
        'storeComment'
    ])->name('blog.comment.store');

    Route::post('{id}/comment/{commentId}/destroy', [
        BlogController::class,
        'destroyComment'
    ])->name('blog.comment.destroy');
});

///////////handicraftRepos/////////////////////////

Route::group(
    ['prefix' => 'product', 'middleware' => ['manual.auth']],
    function () {

        Route::get('', [
            'uses' => 'ProductController@index',
            'as' => 'product.index'
        ]);

        Route::get('show/{id_p}', [
            'uses' => 'ProductController@show',
            'as' => 'product.show'
        ]);

        Route::get('create', [
            'uses' => 'ProductController@create',
            'as' => 'product.create'
        ]);

        Route::post('create', [
            'uses' => 'ProductController@store',
            'as' => 'product.store'
        ]);

        Route::get('update/{id_p}', [
            'uses' => 'ProductController@edit',
            'as' => 'product.edit'
        ]);

        Route::post('update/{id_p}', [
            'uses' => 'ProductController@update',
            'as' => 'product.update'
        ]);

        Route::get('delete/{id_p}', [
            'uses' => 'ProductController@confirm',
            'as' => 'product.confirm'
        ]);

        Route::post('delete/{id_p}', [
            'uses' => 'ProductController@destroy',
            'as' => 'product.destroy'
        ]);
    }
);

/////////////admin///////////////////

Route::group(['prefix' => 'admin', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'AdminController@index',
        'as' => 'admin.index'
    ]);

    Route::get('show/{id_a}', [
        'uses' => 'AdminController@show',
        'as' => 'admin.show'
    ]);

    Route::get('update/{id_a}', [
        'uses' => 'AdminController@edit',
        'as' => 'admin.edit'
    ]);

    Route::post('update/{id_a}', [
        'uses' => 'AdminController@update',
        'as' => 'admin.update'
    ]);
});
///////////////Category////////////////////


Route::group(['prefix' => 'category', 'middleware' => ['manual.auth']], function () {

    Route::get('', [
        'uses' => 'CategoryController@index',
        'as' => 'category.index'
    ]);

    Route::get('show/{id_cate}', [
        'uses' => 'CategoryController@show',
        'as' => 'category.show'
    ]);

    Route::get('create', [
        'uses' => 'CategoryController@create',
        'as' => 'category.create'
    ]);

    Route::post('create', [
        'uses' => 'CategoryController@store',
        'as' => 'category.store'
    ]);

    Route::get('update/{id_cate}', [
        'uses' => 'CategoryController@edit',
        'as' => 'category.edit'
    ]);

    Route::post('update/{id_cate}', [
        'uses' => 'CategoryController@update',
        'as' => 'category.update'
    ]);

    Route::get('delete/{id_cate}', [
        'uses' => 'CategoryController@confirm',
        'as' => 'category.confirm'
    ]);

    Route::post('delete/{id_cate}', [
        'uses' => 'CategoryController@destroy',
        'as' => 'category.destroy'
    ]);
});

////////////////////////Customer////////////////////////////////////
Route::group(['prefix' => 'customer', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'CustomerController@index',
        'as' => 'customer.index'
    ]);

    Route::get('show/{id_c}', [
        'uses' => 'CustomerController@show',
        'as' => 'customer.show'
    ]);

    Route::get('update/{id_c}', [
        'uses' => 'CustomerController@edit',
        'as' => 'customer.edit'
    ]);

    Route::put('update/{id_c}', [
        'uses' => 'CustomerController@update',
        'as' => 'customer.update'
    ]);

    Route::get('delete/{id_c}', [
        'uses' => 'CustomerController@confirm',
        'as' => 'customer.confirm'
    ]);

    Route::post('delete/{id_c}', [
        'uses' => 'CustomerController@destroy',
        'as' => 'customer.destroy'
    ]);

    // Thêm route POST cho việc tạo mới customer
    Route::post('create', [
        'uses' => 'CustomerController@store',
        'as' => 'customer.store'
    ]);
});

// Chỉ cho phép user đã đăng nhập vào chat
Route::middleware(['manual.auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/search', [ChatController::class, 'search'])->name('chat.search');
});

Route::middleware(['manual.auth'])->group(function () {
    Route::get('/auth/google', [GoogleMeetController::class, 'auth'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleMeetController::class, 'callback'])->name('auth.google.callback');
    Route::get('/test-meet', [GoogleMeetController::class, 'test']);
});

Route::middleware(['manual.auth'])->group(function () {
    Route::get('/learning-materials', [LearningMaterialController::class, 'index'])->name('learning_materials.index');
    Route::get('/learning-materials/upload', [LearningMaterialController::class, 'create'])->name('learning_materials.create');
    Route::post('/learning-materials/store', [LearningMaterialController::class, 'store'])->name('learning_materials.store');

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/learning-materials/pending', [LearningMaterialController::class, 'pending'])->name('learning_materials.pending');
        Route::post('/learning-materials/approve/{id}', [LearningMaterialController::class, 'approve'])->name('learning_materials.approve');
        Route::post('/learning-materials/reject/{id}', [LearningMaterialController::class, 'reject'])->name('learning_materials.reject');
        //Timetable function CRUD//
        Route::post('/timetable', [TimetableController::class, 'addTimetable']); // Add Timetable
        Route::put('/timetable/{id}', [TimetableController::class, 'updateTimetable']); // Update
        Route::delete('/timetable/{id}', [TimetableController::class, 'deleteTimetable']); // Delete
    });

    Route::get('/learning-materials/download/{id}', [LearningMaterialController::class, 'download'])->name('learning_materials.download');
});

Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index'); //TODO: chỉnh lại route của timetable.


// Route để xem thông tin cơ sở dữ liệu
/////////////////////////////////////////////////
