<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// chức năng đăng nhập, đăng ký, quên mật khẩu, đổi mật khẩu
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'doLogin']);
Route::get('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
Route::get('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'forgotPasswordIndex']);
Route::post('/forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'forgotPassword']);
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\AuthController::class, 'resetPasswordIndex']);
Route::post('/reset-password', [App\Http\Controllers\Auth\AuthController::class, 'resetPassword']);


// dam bao cac route phai dang nhap moi duoc truy cap
Route::group(['middleware' => 'checkLogin'], function () {

  // group route for admin
  Route::group(['prefix' => 'admin'], function () {

    // route for student
    Route::get('/students/index', [\App\Http\Controllers\Admin\StudentController::class, 'index']);
    Route::get('/students/edit/{id}', [\App\Http\Controllers\Admin\StudentController::class, 'edit']);
    Route::post('/students/edit', [\App\Http\Controllers\Admin\StudentController::class, 'update']);
    Route::post('/students/update-score', [\App\Http\Controllers\Admin\StudentController::class, 'updateScore']);
    Route::post('/students/exportSelected', [\App\Http\Controllers\Admin\StudentController::class, 'exportSelected']);
    Route::post('/students/importScore', [\App\Http\Controllers\Admin\StudentController::class, 'importScore']);
    Route::get('/students/wait-test', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'waitTest']);
    Route::get('/students/create-wait-test', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'createWaitTest']);
    Route::post('/students/create-wait-test', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'storeWaitTest']);
    Route::get('/students/wait-test/edit/{id}', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'editWaitTest']);
    Route::post('/students/wait-test/edit', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'updateWaitTest']);
    Route::post('/students/delete-wait-test', [\App\Http\Controllers\Admin\StudentWaitTestController::class, 'deleteWaitTest']);
    Route::get('/students/wait-class', [\App\Http\Controllers\Admin\StudentWaitClassController::class, 'waitClass']);
    Route::post('/students/wait-class/save', [\App\Http\Controllers\Admin\StudentWaitClassController::class, 'saveWaitClass']);
   
    // route for contract
    // Route::get('/contracts/index', [\App\Http\Controllers\Admin\StudentContractController::class, 'index']);
    // Route::get('/contracts/add', [\App\Http\Controllers\Admin\StudentContractController::class, 'addContract']);

    // route for setting
    Route::get('/settings/languages/index', [\App\Http\Controllers\Admin\Settingcontroller::class, 'languageIndex']);
    Route::post('/settings/languages/add', [\App\Http\Controllers\Admin\Settingcontroller::class, 'languageAdd']);
    Route::post('/settings/languages/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'languageUpdate']);
    Route::post('/settings/languages/delete', [\App\Http\Controllers\Admin\Settingcontroller::class, 'languageDelete']);
    Route::get('/settings/certificates/index', [\App\Http\Controllers\Admin\Settingcontroller::class, 'certificateIndex']);
    Route::post('/settings/certificates/add', [\App\Http\Controllers\Admin\Settingcontroller::class, 'certificateAdd']);
    Route::post('/settings/certificates/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'certificateUpdate']);
    Route::post('/settings/certificates/delete', [\App\Http\Controllers\Admin\Settingcontroller::class, 'certificateDelete']);
    Route::get('/settings/levels/index', [\App\Http\Controllers\Admin\Settingcontroller::class, 'levelIndex']);
    Route::post('/settings/levels/add', [\App\Http\Controllers\Admin\Settingcontroller::class, 'levelAdd']);
    Route::post('/settings/levels/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'levelUpdate']);
    Route::post('/settings/levels/delete', [\App\Http\Controllers\Admin\Settingcontroller::class, 'levelDelete']);
    Route::get('/settings/shifts/index', [\App\Http\Controllers\Admin\Settingcontroller::class, 'shiftIndex']);
    Route::post('/settings/shifts/add', [\App\Http\Controllers\Admin\Settingcontroller::class, 'shiftAdd']);
    Route::post('/settings/shifts/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'shiftUpdate']);
    Route::post('/settings/shifts/delete', [\App\Http\Controllers\Admin\Settingcontroller::class, 'shiftDelete']);
    Route::get('/settings/informations/index', [\App\Http\Controllers\Admin\Settingcontroller::class, 'informationIndex']);
    Route::post('/settings/informations/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'updateInformation']);
    Route::post('/settings/bank-accounts/add', [\App\Http\Controllers\Admin\Settingcontroller::class, 'addBankAccount']);
    Route::post('/settings/bank-accounts/update', [\App\Http\Controllers\Admin\Settingcontroller::class, 'updateBankAccount']);
    Route::post('/settings/bank-accounts/delete', [\App\Http\Controllers\Admin\Settingcontroller::class, 'deleteBankAccount']);

    // routes for courses
    Route::get('courses/index', [\App\Http\Controllers\Admin\CourseController::class, 'getIndex']);
    Route::get('courses/add', [\App\Http\Controllers\Admin\CourseController::class, 'addCourse']);
    Route::post('courses/store', [\App\Http\Controllers\Admin\CourseController::class, 'storeCourse']);
    Route::get('courses/edit/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'editCourse']);
    Route::post('courses/update/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'updateCourse']);
    Route::get('courses/delete/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'deleteCourse']);

    // routes for classes
    Route::get('/classes/class', [\App\Http\Controllers\Admin\ClassController::class, 'getIndex']);
    Route::get('/classes/add-class', [\App\Http\Controllers\Admin\ClassController::class, 'addClass']);
    Route::post('/classes/store', [\App\Http\Controllers\Admin\ClassController::class, 'storeClass']);
    Route::get('/classes/edit/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'editClass']);
    Route::post('/classes/update/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'updateClass']);
    Route::post('/classes/delete/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'deleteClass']);
    Route::get('/classes/class-schedule/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'getSchedule']);
    Route::get('/classes/attendance/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'getAttendance']);
    Route::post('/classes/attendance/save/{id}', [\App\Http\Controllers\Admin\ClassController::class, 'saveAttendance']);

    
    // route for contract
    Route::get('/contracts/index', [\App\Http\Controllers\Admin\ContractController::class, 'index']);
    Route::get('/contracts/add', [\App\Http\Controllers\Admin\ContractController::class, 'addContractIndex']);
    Route::post('/contracts/add', [\App\Http\Controllers\Admin\ContractController::class, 'addContract']);
    Route::post('/contracts/addbill', [\App\Http\Controllers\Admin\ContractController::class, 'addBill']);
    Route::post('/contracts/deletebill', [\App\Http\Controllers\Admin\ContractController::class, 'deleteBill']);
    Route::get('/contracts/update/{id}', [\App\Http\Controllers\Admin\ContractController::class, 'updateContractIndex']);
    Route::post('/contracts/update', [\App\Http\Controllers\Admin\ContractController::class, 'updateContract']);
    Route::post('/contracts/delete', [\App\Http\Controllers\Admin\ContractController::class, 'deleteContract']);

    // route for teacher
    Route::get('/teachers/index', [\App\Http\Controllers\Admin\TeacherController::class, 'index']);
    Route::get('/teachers/add', [\App\Http\Controllers\Admin\TeacherController::class, 'addTeacherIndex']);
    Route::post('/teachers/add', [\App\Http\Controllers\Admin\TeacherController::class, 'addTeacher']);
    Route::get('/teachers/update/{id}', [\App\Http\Controllers\Admin\TeacherController::class, 'updateTeacherIndex']);
    Route::post('/teachers/update', [\App\Http\Controllers\Admin\TeacherController::class, 'updateTeacher']);
    Route::post('/teachers/delete', [\App\Http\Controllers\Admin\TeacherController::class, 'deleteTeacher']);
    Route::get('/teachers/salary', [\App\Http\Controllers\Admin\TeacherController::class, 'salaryIndex']);
    Route::post('/teachers/salary/export', [\App\Http\Controllers\Admin\TeacherController::class, 'exportSalary']);


    // route for profile
    Route::get('/profile/index', [\App\Http\Controllers\Auth\ProfileController::class, 'index']);
    Route::post('/profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'updateProfile']);
    Route::get('/profile/change-password', [\App\Http\Controllers\Auth\ProfileController::class, 'changePasswordIndex']);
    Route::post('/profile/update-password', [\App\Http\Controllers\Auth\ProfileController::class, 'updatePassword']);

    // Route for dashboard
    Route::get('/dashboard/index', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);


  });
  // group route for teacher
  Route::group(['prefix' => 'teacher'], function () {

    // route for schedule
    Route::get('/teach-schedule/index', [\App\Http\Controllers\Teacher\TeacherController::class, 'index']);
    Route::get('/classes/index', [\App\Http\Controllers\Teacher\TeacherController::class, 'classesIndex']);
    Route::get('/class-details/{id}', [\App\Http\Controllers\Teacher\TeacherController::class, 'classDetailsIndex']);
    Route::post('/class-detail/update', [\App\Http\Controllers\Teacher\TeacherController::class, 'classDetailUpdate']);


    // route for final-exam
    Route::get('/final-exam/index/{id}', [\App\Http\Controllers\Teacher\TeacherController::class, 'finalExamIndex']);
    Route::post('/final-exam/update', [\App\Http\Controllers\Teacher\TeacherController::class, 'finalExamUpdate']);
    Route::get('/final-exam/export/{class_id}', [\App\Http\Controllers\Teacher\TeacherController::class, 'exportFinalExam']);
    Route::post('/final-exam/import', [\App\Http\Controllers\Teacher\TeacherController::class, 'importFinalExam']);

    // route for profile
    Route::get('/profile/index', [\App\Http\Controllers\Auth\ProfileController::class, 'index']);
    Route::post('/profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'updateProfile']);
    Route::get('/profile/change-password', [\App\Http\Controllers\Auth\ProfileController::class, 'changePasswordIndex']);
    Route::post('/profile/update-password', [\App\Http\Controllers\Auth\ProfileController::class, 'updatePassword']);
   
  });
  // group route for student
  Route::group(['prefix' => 'student'], function () {

    // route for schedule
    Route::get('/all-schedule', [\App\Http\Controllers\Student\StudentController::class, 'getAllSchedule']);
    Route::get('/class-learned', [\App\Http\Controllers\Student\StudentController::class, 'historyLearnedIndex']);
    Route::get('/class-learned/search', [\App\Http\Controllers\Student\StudentController::class, 'quickSearchClass']);
    Route::get('/student-schedule/{id}', [\App\Http\Controllers\Student\StudentController::class, 'studentSchedule']);
    Route::get('/bill-history', [\App\Http\Controllers\Student\StudentController::class, 'historyBillIndex']);

    // route for profile
    Route::get('/profile/index', [\App\Http\Controllers\Auth\ProfileController::class, 'index']);
    Route::post('/profile/update', [\App\Http\Controllers\Auth\ProfileController::class, 'updateProfile']);
    Route::get('/profile/change-password', [\App\Http\Controllers\Auth\ProfileController::class, 'changePasswordIndex']);
    Route::post('/profile/update-password', [\App\Http\Controllers\Auth\ProfileController::class, 'updatePassword']);


  });
});

