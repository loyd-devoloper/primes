<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Recruitment_Job;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Traits\ApplicantFileUploadTrait;

class RecruitmentController extends Controller
{
    use ApplicantFileUploadTrait;
    public function getJobs(Request $request)
    {

        if ($request->q) {
            $users = Recruitment_Job::query()
                ->select([
                    'job_id',
                    'job_title',
                    'education',
                    'eligibility',
                    'experience',
                    'plantilla_item',
                    'training',
                    'status_of_hiring'
                ])
                ->with('batchInfo',function ($q){
                    $q->select(['closing_date','posting_date','job_id']);
                })
                ->whereHas('batchInfo', function ($q) {
                $q->whereDate('posting_date', '<=', Carbon::today())
                    ->where('closing_date','>=', Carbon::now())
                    ->where('status', 1);
                })
                ->where('job_title', 'LIKE', '%' . $request->q . '%')
                ->simplePaginate(10);
        } else {
            $users = Recruitment_Job::query()
                ->select([
                    'job_id',
                    'job_title',
                    'education',
                    'eligibility',
                    'experience',
                    'plantilla_item',
                    'training',
                    'status_of_hiring'
                ])
                ->with('batchInfo',function ($q){
                    $q->select(['closing_date','posting_date','status','job_id']);
                })
                ->where('status_of_hiring', 1)
                ->whereHas('batchInfo', function ($q) {
                $q->whereDate('posting_date', '<=', Carbon::today())->where('closing_date','>=', Carbon::now())->where('status', 1);
                })
                ->simplePaginate(perPage: 10);
        }
        return response()->json($users);
    }
    public function getJob(Request $request)
    {

        $users = Recruitment_Job::query()
            ->select([
                'description',
                'job_id',
                'job_title',
                'education',
                'eligibility',
                'experience',
                'plantilla_item',
                'training',
                'status_of_hiring'
            ])
            ->with('batchInfo',function ($q){
                $q->select(['closing_date','posting_date','job_id']);
            })
            ->whereHas('batchInfo', function ($q) {
            $q->whereDate('posting_date', '<=', Carbon::today())->where('closing_date','>=', Carbon::now())->where('status', 1);
            })
            ->where('job_id', $request->id)->first();

        return response()->json($users);
    }
    public function viewApplicantApplication($application_code)
    {
        try {
            $application = \App\Models\RecruitmetJobApplication::with(['activities'=>function($q){
                $q->select('applicant_id','message','created_at')
                    ->where('message','Pending => Not Qualified')
                    ->orWhere('message','Validate => Qualified')
                    ->orWhere('message','Pending => Validate')
                    ->orWhere('message','Open Ranking Email')
                    ->orWhere('message','CAR Email');
            },'jobInfo'=>function($q){
                return $q->with('batchInfo');
            }])
            // ->whereHas('jobInfo.batchInfo',function($q){
            //     $q->where('closing_date','>=', Carbon::now())->where('status', 1);
            // })
            ->where('application_code', Crypt::decryptString($application_code))->first();
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(false,404);
        }

        return response()->json($application);
    }
    public function updateApplication(Request $request, $applicant_id)
    {

        $application = \App\Models\RecruitmetJobApplication::with(['jobInfo'=>function($q){
            return $q->with('batchInfo');
        }])->where('application_code', Crypt::decryptString($applicant_id))->first();
        $arr = [
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'religion' => $request->religion,
            'disability' => $request->disability,
            'ethnic_group' => $request->ethnic_group,
            'email' => Crypt::encryptString($request->email),
            'mobile_number'  => Crypt::encryptString($request->mobile_number),
            'address' => Crypt::encryptString($request->address),
            'sex' => $request->sex,
            'birthdate' => $request->birth_date,
            'civil_status' => $request->civil_status,
            'job_id' => $application->job_id,
            'batch_id' => $application?->batch_id,
        ];

        $keys = ['letter_of_intent', 'pds', 'prc', 'tor', 'training_attended','certificate_of_employment','latest_appointment','performance_rating','cav','awards_recognition','research_innovation','membership_in_national','resource_speakership','neap','application_of_education','l_and_d'];

        foreach ($keys as $key) {
            if (!!$request->$key && $request->$key != 'undefined') {
                $file_path = "public/recruitment/application/".$application->jobInfo->job_title."/".$application->jobInfo->batchInfo->batch_name."/".$application->email."/".$application[$key];
                    if(!!$application->$key)
                    {
                        if(Storage::exists($file_path))
                        {
                            Storage::delete($file_path);
                        }

                    }

                $arr[$key] = $this->fileUpload($request, $request->email, $key, $application->jobInfo?->job_title, $application->jobInfo?->batchInfo?->batch_name);
            }
        }
        $application->update($arr);
        \App\Models\ApplicantLog::create([
            'activity' => 'Update Application',
            'message' => 'Applicant updated their application.',
            'applicant_id' => $application?->id,
            'type' => '1'
        ]);

    }
    public function storeApplication(Request $request)
    {


        $job = Recruitment_Job::with('batchInfo')->select('job_id', 'application_code', 'job_title', 'place_of_assignment','id')->where('job_id', $request->job_id)->first();
        $checkApplicant = \App\Models\RecruitmetJobApplication::query()->where(function ($q) use ($request) {
            $q->where('fname', $request->fname)->where('lname', $request->lname);
        })->where('batch_id', $job->batchInfo?->batch_id)->where('job_id', $request->job_id)->first();
        if ($checkApplicant) {
            return response()->json(['only_one' => true]);
        }
        try {
            $uuid = Carbon::now()->format('Y-m-d');
            $letter_of_intent = $this->fileUpload($request, $request->email, 'letter_of_intent', $job->id, $job->batchInfo?->id);
            $pds = $this->fileUpload($request, $request->email, 'pds', $job->id, $job->batchInfo?->id);
            $prc = $this->fileUpload($request, $request->email, 'prc', $job->id, $job->batchInfo?->id);
            // $eligibility = $this->fileUpload($request, $request->email, 'eligibility',$job->id,$job->batchInfo?->id);
            $tor = $this->fileUpload($request, $request->email, 'tor', $job->id, $job->batchInfo?->id);
            $training_attended = $this->fileUpload($request, $request->email, 'training_attended', $job->id, $job->batchInfo?->id);
            $certificate_of_employment = $this->fileUpload($request, $request->email, 'certificate_of_employment', $job->id, $job->batchInfo?->id);
            $latest_appointment = $this->fileUpload($request, $request->email, 'latest_appointment', $job->id, $job->batchInfo?->id);
            $performance_rating = $this->fileUpload($request, $request->email, 'performance_rating', $job->id, $job->batchInfo?->id);
            $cav = $this->fileUpload($request, $request->email, 'cav', $job->id, $job->batchInfo?->id);
            $awards_recognition = $this->fileUpload($request, $request->email, 'awards_recognition', $job->id, $job->batchInfo?->id);
            $research_innovation = $this->fileUpload($request, $request->email, 'research_innovation', $job->id, $job->batchInfo?->id);
            $membership_in_national = $this->fileUpload($request, $request->email, 'membership_in_national', $job->id, $job->batchInfo?->id);
            $resource_speakership = $this->fileUpload($request, $request->email, 'resource_speakership', $job->id, $job->batchInfo?->id);
            $neap = $this->fileUpload($request, $request->email, 'neap', $job->id, $job->batchInfo?->id);
            $application_of_education = $this->fileUpload($request, $request->email, 'application_of_education', $job->id, $job->batchInfo?->id);
            $l_and_d = $this->fileUpload($request, $request->email, 'l_and_d', $job->id, $job->batchInfo?->id);
            $data = [
                'letter_of_intent' => $letter_of_intent,
                'pds' => $pds,
                'prc' => $prc,
                // 'eligibility' => $eligibility,
                'tor' => $tor,
                'training_attended' => $training_attended,
                'certificate_of_employment' => $certificate_of_employment,
                'latest_appointment' => $latest_appointment,
                'performance_rating' => $performance_rating,
                'cav' => $cav,
                'awards_recognition' => $awards_recognition,
                'research_innovation' => $research_innovation,
                'membership_in_national' => $membership_in_national,
                'resource_speakership' => $resource_speakership,
                'neap' => $neap,
                'application_of_education' => $application_of_education,
                'l_and_d' => $l_and_d,
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'religion' => $request->religion,
                'disability' => $request->disability,
                'ethnic_group' => $request->ethnic_group,
                'email' => Crypt::encryptString($request->email),
                'mobile_number'  => Crypt::encryptString($request->mobile_number),
                'address' => Crypt::encryptString($request->address),
                'sex' => $request->sex,
                'birthdate' => $request->birth_date,
                'civil_status' => $request->civil_status,
                'job_id' => $request->job_id,
                'batch_id' => $job->batchInfo?->batch_id,
            ];
            $codes = DB::transaction(function () use ($data, $job, $request) {

                $id = \App\Models\RecruitmetJobApplication::query()
                    ->create($data);
                \App\Models\ApplicantLog::create([
                    'activity' => 'Send Email',
                    'message' => 'Acknowledgement Email',
                    'applicant_id' => $id->id,
                    'type' => '10'
                ]);

                $application_code = Carbon::now()->format('Y') . '-' . $job->application_code . '-' . $id->id;

                $id->update([
                    'application_code' => $application_code,
                ]);
                $id->with(['jobInfo'=>function($q)
                {
                   $q->with('batchInfo');
                },'eligibilityInfo','jobOtherInformation']);
                $crypt = Crypt::encryptString($application_code);
                $link = config('app.front_end')."/my_applicant/$crypt";
                Mail::to($request->email)->queue(new \App\Mail\Recruitment\ApplicantSubmittedEmail($id,$link));


                return ["code" =>$application_code,"link"=>$link] ;
            });

            return response()->json($codes);
        } catch (\Throwable $th) {
            return response()->json($th, 200);
        }
    }
}
