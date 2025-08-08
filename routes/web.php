<?php


use App\Livewire\Auth\Login;
use App\Livewire\IdPractice;
use App\Livewire\ActivityLog;
use App\Livewire\ID\Generate;
use App\Livewire\ID\Template;
use App\Livewire\ID\Dashboard;
use App\Livewire\Personnel\Home;
use App\Livewire\Recruitment\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Livewire\CAD\Home as CADHome;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\EmployeeProfile;
use App\Livewire\Auth\ValidateEmployee;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\ExportController;

use App\Livewire\Recruitment\AllApplicant;
use App\Livewire\Recruitment\Applications;
use App\Livewire\PersonalDataSheet\OtherInfo;
use App\Livewire\Recruitment\Step1\CheckFile;
use App\Livewire\Recruitment\ApplicationTable;
use App\Livewire\PersonalDataSheet\Association;
use App\Livewire\PersonalDataSheet\Distinction;
use App\Livewire\PersonalDataSheet\Eligibility;
use App\Mail\Recruitment\CheckFileNotification;
use App\Livewire\PersonalDataSheet\SkillsHobbies;
use App\Livewire\PersonalDataSheet\WorkExperience;
use App\Livewire\PersonalDataSheet\FamilyBackground;
use App\Livewire\PersonalDataSheet\LearningDevelopment;
use App\Livewire\PersonalDataSheet\PersonalInformation;
use App\Livewire\PersonalDataSheet\EducationalBackground;
use App\Livewire\PersonalDataSheet\AffiliationInvolvement;
use App\Livewire\Recruitment\Step1\CheckFile\CheckFileView;
use App\Livewire\Recruitment\Step1\CheckFile\CheckFileTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Middleware\PermissionMiddleware;

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

Route::get('/mail', function () {

    //  $data = \App\Models\RecruitmetJobApplication::with(['jobInfo'=>function($q)
    //  {
    //     $q->with('batchInfo');
    //  },'eligibilityInfo','jobOtherInformation'])->where('application_code','2024-FD-CADOF-270364-2004-100')->first();

    //  $link = config('app.front_end')."/my_applicant";


    // return new  \App\Mail\Recruitment\Car();
});
Route::view('/download', 'livewire.recruitment.assets.pdf_template.general_services');

// practice route
Route::get('/bio', fn() => view('bio'));
Route::get('/w', [DemoController::class, 'w']);
Route::post('/w', [DemoController::class, 'store']);
Route::get('/dtrDemo', [DemoController::class, 'dtrDemo']);
Route::get('/export', [ExportController::class, 'index']);
Route::get('/', fn() => redirect()->route('auth.login'));
Route::get('/id_practice', IdPractice::class);
Route::get('/xxx', Generate::class);
Route::get('/welcome', fn() => view('welcome'));

Route::post('/export', [ExportController::class, 'exportUsser'])->name('exportPds')->middleware('auth.user');
// personnel route
Route::prefix('personnel')->group(function () {
    // validate route
    Route::get('/validate', ValidateEmployee::class)->name('auth.validate.employee');
    // personnel profile
    Route::get('profile/{id}', EmployeeProfile::class)->name('auth.employee.profile');
    Route::get('auth/otp/{id}', \App\Livewire\Auth\Otp::class)->name('auth.otp');
    // personnel login
    Route::get('/login', Login::class)->name('auth.login');
    // personnel home
    Route::middleware(['auth.user','auth.session','auth'])->group(function () {

        Route::get('/home', Home::class)->name('personnel.home');
        Route::get('/PersonalInfo', PersonalInformation::class)->name('personnel.pds.personal_informatiom');
        Route::get('/FamilyBackground', FamilyBackground::class)->name('personnel.pds.family_background');
        Route::get('/EducationalBackground', EducationalBackground::class)->name('personnel.pds.educational_background');
        Route::get('/Eligibility', Eligibility::class)->name('personnel.pds.eligibility');
        Route::get('/WorkExperience', WorkExperience::class)->name('personnel.pds.work_experience');
        Route::get('/AffiliationInvolvement', AffiliationInvolvement::class)->name('personnel.pds.affiliation_involvement');
        Route::get('/LearningDevelopment', LearningDevelopment::class)->name('personnel.pds.learning_development');
        Route::get('/SkillsHobbies', SkillsHobbies::class)->name('personnel.pds.skill_hobbies');
        Route::get('/Distinction&Recognition', Distinction::class)->name('personnel.pds.distinction');
        Route::get('/Association&Organization', Association::class)->name('personnel.pds.association');
        Route::get('/OtherInfo', OtherInfo::class)->name('personnel.pds.other_info');
        Route::get('/personnel/logout', [AuthController::class, 'logging_out'])->name('auth.logout');

        // GAD
        Route::prefix('gad')->group(function () {
            Route::get('/', CADHome::class)->name('cad.home');
        });
        // ID
        Route::prefix('Generatin-ID')->group(function () {
            Route::get('/', Dashboard::class)->name('id.dashboard');
            Route::get('/template', Template::class)->name('id.template');
        });
    });

    // recruitment
    Route::middleware(['auth.user','auth.session','auth'])->prefix('recruitment')->group(function () {
        Route::get('jobs', Job::class)->name('recruitment.jobs');
        Route::get('job-information/{job_title}/{job_id}', \App\Livewire\Recruitment\ViewJobInformation::class)->name('recruitment.view_job');
        Route::get('applications', Applications::class)->name('recruitment.applications');
        Route::get('applications-table/{job_title}/{id}', ApplicationTable::class)->name('recruitment.application.table');
        Route::get('all-applications', AllApplicant::class)->name('recruitment.all.applicant');
        Route::get('monitoring', \App\Livewire\Recruitment\RsaMonitoring::class)->name('recruitment.monitoring');

        // psb
        Route::get('/psb', \App\Livewire\Recruitment\PsbDashboard::class)->name('recruitment.psb');
        Route::get('/psb/{job_title}/{job_batch}/{job_id}', \App\Livewire\Recruitment\PsbApplicant::class)->name('recruitment.psb.applicant');
        Route::get('psb/personnel/grading/{job_title}/{job_id}/{job_batch}', \App\Livewire\Recruitment\PsbPersonnelGrading::class)->name('recruitment.psb_personnel_grading');
    });


    // Leave
    Route::middleware(['auth.user','auth.session','auth'])->prefix('leave')->group(function () {
        Route::get('all_request', \App\Livewire\Leave\AllRequest::class)->name('leave.all_request');
        Route::get('my_leave', \App\Livewire\Leave\MyLeave::class)->name('leave.my_leave');
        Route::get('employees', \App\Livewire\Leave\Employees::class)->name('leave.employees');
        Route::get('employees/{employee_name}/{employee_id}', \App\Livewire\Leave\EmployeesView::class)->name('leave.employees.view');
        Route::get('Request/{title}/{request_id}', \App\Livewire\Leave\RequestView::class)->name('leave.request.view');

        // head
        Route::get('head', \App\Livewire\Leave\HeadTab::class)->name('leave.head.tab');
        Route::get('chief', \App\Livewire\Leave\ChiefTab::class)->name('leave.chief.tab');
        Route::get('Rd', \App\Livewire\Leave\RdTab::class)->name('leave.rd.tab');

        Route::get('personnel/advance_setting', \App\Livewire\Leave\Personnel\AdvanceSetting::class)->name('leave.personnel.advance_setting');
        Route::get('personnel/calendar', \App\Livewire\Leave\Personnel\Calendar::class)->name('leave.personnel.calendar');



        // records
        Route::get('records/pending',\App\Livewire\Leave\Records\Pending::class)->name('leave.records.pending');
        Route::get('records/archived',\App\Livewire\Leave\Records\Archived::class)->name('leave.records.archived');
    });
    // Dtr qrcode
    Route::get('dtr/{dtr_id}', \App\Livewire\Leave\Asset\VerifyDtr::class)->name('dtr_qrcode');
    // User Management
    Route::middleware(['auth.user','auth.session','auth'])->prefix('UserManagement')->group(function () {
        Route::get('permission', \App\Livewire\UserManagement\Permission::class)->name('user_management.permission');
        Route::get('users', \App\Livewire\UserManagement\Users::class)->name('user_management.users');
    });
    // Task Board
    Route::middleware(['auth.user','auth.session','auth'])->prefix('TaskBoard')->group(function () {
        Route::get('/', \App\Livewire\TaskTable::class)->name('task');
        Route::get('/TaskBoard/{task_name}/{task_id}', \App\Livewire\TaskBoard::class)->name('task_board');

    });
    // Activity log
    Route::get('activity_logs', ActivityLog::class)->middleware('auth.user')->name('activitylog');
    Route::get('SYSTEM-FEEDBACK', \App\Livewire\Feedback::class)->middleware('auth.user')->name('system_feedback');

    // Office management
    Route::get('/offices', \App\Livewire\OfficeManagement\offices::class)->name('offices');
});
Route::get('/print', function () {
    // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('livewire.leave.asset.leave_card')->setPaper('a4', 'landscape');
    // return $pdf->download('invoice.pdf');
    return view('livewire.leave.asset.leave_card');
});
