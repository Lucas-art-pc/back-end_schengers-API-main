<?php

use App\Http\Controllers\Api\Admin\DataStudents;
use App\Http\Controllers\Api\Admin\DataTeachers;
use App\Http\Controllers\Api\Admin\TasksController;
use App\Http\Controllers\Api\Area\AreasController;
use App\Http\Controllers\Api\Auth\DataUserController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginAdminController;
use App\Http\Controllers\Api\Auth\LoginStudentController;
use App\Http\Controllers\Api\Auth\LoginTeacherController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterAdminController;
use App\Http\Controllers\Api\Auth\RegisterStudentController;
use App\Http\Controllers\Api\Auth\RegisterTeacherController;
use App\Http\Controllers\Api\Auth\UserEditData;
use App\Http\Controllers\Api\Course\ActivityCourse\ActivityCourseController;
use App\Http\Controllers\Api\Course\ActivityCourse\AnswersCourseController;
use App\Http\Controllers\Api\Course\CertificateController;
use App\Http\Controllers\Api\Course\ClassCourse\ClassCourseController;
use App\Http\Controllers\Api\Course\CourseController;
use App\Http\Controllers\Api\Enrollment\EnrollmentController;
use App\Http\Controllers\Api\StudyPlan\StudyPlanController;
use App\Http\Controllers\Api\SupportUser\SupportController;
use App\Http\Controllers\Api\Teacher\ActionCurriculumController;
use App\Http\Controllers\Api\Teacher\CurriculumController;
use App\Http\Controllers\Api\Teacher\DashboardTeacherController;
use App\Http\Controllers\Api\Vacancy\VacancyController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/dataUser', DataUserController::class);

Route::prefix('auth')->group(function () {

    Route::post('user/register', RegisterStudentController::class);
    Route::post('/login', LoginStudentController::class);

    Route::post('/logout', LogoutController::class)
        ->middleware('auth:sanctum');
    Route::post('/change-password', [UserEditData::class, "editPassword"])->middleware('auth:sanctum');
    Route::post('/update-avatar', [UserEditData::class, "updateAvatar"])->middleware('auth:sanctum');
    Route::post('/forgot-password', [ForgotPasswordController::class, "forgotPassword"]);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);


    Route::prefix('/teacher')->group(function () {
        Route::post('/register', RegisterTeacherController::class);
        Route::post('/login', LoginTeacherController::class);
    });

    Route::prefix('admin')->group(function () {
        Route::post('/login', LoginAdminController::class);


        Route::post('/', RegisterAdminController::class);
    });
});

Route::prefix('/vacancy')->group(function () {

    Route::get('/', [VacancyController::class, 'index']);
    Route::post('/', [VacancyController::class, 'store']);


    Route::get('/adminVacancies', [VacancyController::class, 'adminIndex']);


    Route::get('/{public_id}', [VacancyController::class, 'show'])->middleware('auth:sanctum');
    Route::delete('/{public_id}', [VacancyController::class, 'destroy']);
    Route::patch('/{public_id}', [VacancyController::class, 'update']);
});

Route::prefix('/curriculum')->group(function () {
    Route::post('/vacancies/{public_id}', [CurriculumController::class, 'store'])
        ->middleware('auth:sanctum');

    Route::get(
        '/vacancies/{public_id}',
        [CurriculumController::class, 'indexByVacancy']
    );

    Route::middleware(['auth:sanctum', 'role:admin'])
        ->get(
            '/{public_id}',
            [CurriculumController::class, 'show']
        );

    Route::patch(
        '/{curriculum}/approve',
        [ActionCurriculumController::class, 'approveCurriculum']
    );

    Route::patch(
        '/{curriculum}/reject',
        [ActionCurriculumController::class, 'rejectCurriculum']
    );
});

Route::prefix('areas')->group(function () {
    Route::get('/', [AreasController::class, 'index']);
    Route::post('/', [AreasController::class, 'store']);
    Route::put('/{id}', [AreasController::class, 'update']);
    Route::delete('/{id}', [AreasController::class, 'destroy']);
});


Route::prefix('courses')->group(function () {

    Route::get('/countPerTeacher', [DashboardTeacherController::class, 'countTeacherCourses'])->middleware('auth:sanctum');
    Route::get('/perTeacher', [DashboardTeacherController::class, 'teacherCourses'])->middleware('auth:sanctum');

    Route::post('/activities/answer', [AnswersCourseController::class, 'answer'])->middleware('auth:sanctum');
    Route::get('/{public_id}/isEnrolled', [CourseController::class, 'isEnrolled'])->middleware('auth:sanctum');
    Route::post('/{public_id}/watchedLesson', [ClassCourseController::class, 'completeLesson'])->middleware('auth:sanctum');
    Route::get('/{public_id}/verifyLesson', [ClassCourseController::class, 'getLessonStatus'])->middleware('auth:sanctum');

    Route::get('/coursesPerStudent', [EnrollmentController::class, 'coursesPerStudent'])->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->post('/{public_id_course}/enroll', [EnrollmentController::class, 'enroll']);

    Route::post('/', [CourseController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/', [CourseController::class, 'index']);

    Route::get('/{public_id}/contentCourse', [CourseController::class, 'showContentCourse'])->middleware('auth:sanctum');

    Route::get('/{public_id}', [CourseController::class, 'show']);
    Route::delete('/{public_id}', [CourseController::class, 'destroy']);
    Route::patch('/{public_id}', [CourseController::class, 'update']);

    Route::get('/{public_id}/classes', [ClassCourseController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/{public_id}/classes/{public_id_class}', [ClassCourseController::class, 'show']);
    Route::post('/{public_id}/classes', [ClassCourseController::class, 'store']);
    Route::patch('/{public_id}/classes/{public_id_class}', [ClassCourseController::class, 'update']);
    Route::delete('/{public_id}/classes/{public_id_class}', [ClassCourseController::class, 'destroy']);

    Route::get('/{public_id}/activities', [ActivityCourseController::class, 'index']);
    Route::post('/{public_id}/activities', [ActivityCourseController::class, 'store']);
    Route::get('/{public_id}/activities/{public_id_activity}', [ActivityCourseController::class, 'show'])->middleware('auth:sanctum');
    Route::patch('/{public_id}/activities/{public_id_activity}', [ActivityCourseController::class, 'update']);
    Route::delete('/{public_id}/activities/{public_id_activity}', [ActivityCourseController::class, 'destroy']);


    Route::get('/certificates/validate/{hash}', [CertificateController::class, 'validate']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/certificates/{course_public_id}', [CertificateController::class, 'show']);
    });
});

Route::prefix('task')->group(function () {
    Route::get('/tasksByTeacher', [TasksController::class, 'indexByTeacher'])->middleware('auth:sanctum');
    Route::post('/{public_id}', [TasksController::class, 'store'])->middleware('auth:sanctum');
});


Route::prefix('support')->group(function () {
    Route::get('/', [SupportController::class, 'supportsIndex']);
    Route::post('/', [SupportController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/supportByUser', [SupportController::class, 'supportByStudent'])->middleware('auth:sanctum');
    Route::post('/{public_id}', [SupportController::class, 'updateStatus'])->middleware('auth:sanctum');
    Route::delete('/{public_id}', [SupportController::class, 'destroy'])->middleware('auth:sanctum');
});


Route::prefix('task')->group(function () {
    Route::get('/tasksByTeacher', [TasksController::class, 'indexByTeacher'])->middleware('auth:sanctum');
    Route::post('/{public_id}', [TasksController::class, 'store'])->middleware('auth:sanctum');
});

Route::prefix('support')->group(function () {
    Route::get('/', [SupportController::class, 'supportsIndex']);
    Route::post('/', [SupportController::class, 'store'])->middleware('auth:sanctum');
    Route::get('/supportByUser', [SupportController::class, 'supportByStudent'])->middleware('auth:sanctum');
    Route::post('/{public_id}', [SupportController::class, 'updateStatus'])->middleware('auth:sanctum');
    Route::delete('/{public_id}', [SupportController::class, 'destroy'])->middleware('auth:sanctum');
});




Route::prefix('studyplan')->group(function () {
    Route::get('/', [StudyPlanController::class, 'index'])->middleware('auth:sanctum');
    Route::post('/', [StudyPlanController::class, 'store'])->middleware('auth:sanctum');
    Route::patch('/{id}', [StudyPlanController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [StudyPlanController::class, 'destroy'])->middleware('auth:sanctum');
});

Route::prefix('admin')->group(function () {
    Route::get('/countStudents', [DataStudents::class, 'countStudents']);
    Route::get('/listStudents', [DataStudents::class, 'indexStudents']);

    Route::get('/counters', [DataTeachers::class, 'counters'])->middleware('auth:sanctum');
    Route::get('/classesPerArea', [DataTeachers::class, 'classesPerArea'])->middleware('auth:sanctum');
    Route::get('/listTeachers', [DataTeachers::class, 'indexTeachers']);
    Route::get('/listCourses', [DataTeachers::class, 'listCourses']);
});
