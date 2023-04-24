<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SchoolYearSectionController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TeacherSubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TORRequestController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth'])->get('/users', [UserController::class, 'get']);
Route::middleware(['auth'])->get('/user/{id}', [UserController::class, 'getOne']);
Route::middleware(['auth'])->get('/userDetails', [UserController::class, 'getUserDetails']);
Route::middleware(['auth'])->get('/profileEditApprovals', [UserController::class, 'getProfileEditApprovals']);
Route::middleware(['auth'])->get('/blockChainUsers', [UserController::class, 'getBlockchainUsers']);
Route::middleware(['auth'])->put('/verifyUser/{id}', [UserController::class, 'verify']);
Route::middleware(['auth'])->put('/rejectUser/{id}', [UserController::class, 'reject']);
Route::middleware(['auth'])->put('/userDetailsStatus/{id}/{userType}', [UserController::class, 'updateUserDetailsStatus']);
Route::middleware(['auth'])->put('/userDetails/{id}', [UserController::class, 'updateUserDetails']);

Route::middleware(['auth'])->get('/subjects', [SubjectController::class, 'get']);
Route::middleware(['auth'])->get('/subject/{id}', [SubjectController::class, 'getOne']);
Route::middleware(['auth'])->post('/subject', [SubjectController::class, 'store']);
Route::middleware(['auth'])->put('/subject/{id}', [SubjectController::class, 'update']);
Route::middleware(['auth'])->delete('/subject/{id}', [SubjectController::class, 'destroy']);

Route::get('/courses', [CourseController::class, 'get']);
Route::middleware(['auth'])->get('/course/{id}', [CourseController::class, 'getOne']);
Route::middleware(['auth'])->post('/course', [CourseController::class, 'store']);
Route::middleware(['auth'])->put('/course/{id}', [CourseController::class, 'update']);
Route::middleware(['auth'])->delete('/course/{id}', [CourseController::class, 'destroy']);

Route::middleware(['auth'])->get('/sections', [SectionController::class, 'get']);
Route::middleware(['auth'])->get('/section/{id}', [SectionController::class, 'getOne']);
Route::middleware(['auth'])->post('/section', [SectionController::class, 'store']);
Route::middleware(['auth'])->put('/section/{id}', [SectionController::class, 'update']);
Route::middleware(['auth'])->delete('/section/{id}', [SectionController::class, 'destroy']);

Route::middleware(['auth'])->get('/schoolYears', [SchoolYearController::class, 'get']);
Route::middleware(['auth'])->get('/schoolYear/{id}', [SchoolYearController::class, 'getOne']);
Route::middleware(['auth'])->get('/schoolYearPublished', [SchoolYearController::class, 'getOnePublished']);
Route::middleware(['auth'])->post('/schoolYear', [SchoolYearController::class, 'store']);
Route::middleware(['auth'])->put('/schoolYear/{id}', [SchoolYearController::class, 'update']);
Route::middleware(['auth'])->put('/schoolYearStatus/{id}', [SchoolYearController::class, 'updateStatus']);
Route::middleware(['auth'])->delete('/schoolYear/{id}', [SchoolYearController::class, 'destroy']);

Route::middleware(['auth'])->get('/schoolYearSection/{syId}', [SchoolYearSectionController::class, 'get']);
Route::middleware(['auth'])->get('/schoolYearSectionFormData/{syId}', [SchoolYearSectionController::class, 'getFormData']);
Route::middleware(['auth'])->post('/schoolYearSection', [SchoolYearSectionController::class, 'store']);
Route::middleware(['auth'])->delete('/schoolYearSection/{syId}/{sectionId}', [SchoolYearSectionController::class, 'destroy']);

Route::middleware(['auth'])->get('/enrollments', [EnrollmentController::class, 'get']);
Route::middleware(['auth'])->get('/enrollments/{studentId}', [EnrollmentController::class, 'getStudentEnrollment']);
Route::middleware(['auth'])->get('/enrollmentItems/{enrollmentId}', [EnrollmentController::class, 'getEnrollmentItems']);
Route::middleware(['auth'])->post('/enrollment', [EnrollmentController::class, 'store']);
Route::middleware(['auth'])->put('/approveEnrollment/{id}', [EnrollmentController::class, 'approve']);
Route::middleware(['auth'])->put('/rejectEnrollment/{id}', [EnrollmentController::class, 'reject']);

Route::middleware(['auth'])->get('/teacherSubjects/{syId}', [TeacherSubjectController::class, 'get']);
Route::middleware(['auth'])->get('/teacherSubject/{id}', [TeacherSubjectController::class, 'getOne']);
Route::middleware(['auth'])->get('/teacherSubjectFormData', [TeacherSubjectController::class, 'getFormData']);
Route::middleware(['auth'])->post('/teacherSubject', [TeacherSubjectController::class, 'store']);
Route::middleware(['auth'])->put('/teacherSubject/{id}', [TeacherSubjectController::class, 'update']);
Route::middleware(['auth'])->delete('/teacherSubject/{id}', [TeacherSubjectController::class, 'destroy']);

Route::middleware(['auth'])->get('/teacherStudents/{syId}/{id}', [TeacherController::class, 'getStudents']);

Route::middleware(['auth'])->post('/grade', [GradeController::class, 'store']);
Route::middleware(['auth'])->put('/grade/{id}', [GradeController::class, 'update']);

Route::middleware(['auth'])->get('/studentGrades/{syId}/{id}', [StudentController::class, 'getGrades']);

Route::middleware(['auth'])->get('/torRequests', [TORRequestController::class, 'get']);
Route::middleware(['auth'])->get('/torRequest/{id}', [TORRequestController::class, 'getOne']);
Route::middleware(['auth'])->post('/torRequest', [TORRequestController::class, 'store']);
Route::middleware(['auth'])->put('/torRequest/{id}', [TORRequestController::class, 'update']);
Route::middleware(['auth'])->delete('/torRequest/{id}', [TORRequestController::class, 'destroy']);