<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentMonitoring extends Model
{
    use HasFactory;
    protected $fillable = [
        'unfilled_position',
        'dbm_plantilla_item_number',
        'salary_grade',
        'year_of_vacancy_posting',
        'date_of_publication',
        'issuance_of_regional_memo',
        'deadline_on_the_submmision_of_application',
        'initial_evaluation_applicants_hrmpsb',
        'initial_evaluation_of_applicants_end_user',
        'recruitment_remarks',


        'office_memo_to_the_hrmpsb',
        'open_ranking_assessment',
        'hrmpsb_deliberation',



        'car',
        'memo_to_and_memo_for',
        'minutes_of_the_meeting',
        'justification_resolution',
        'assesment_with_the_applicant',
        'letter_to_the_successfull_candidate',
        'selection_remarks',



        'appointment',
        'pdf',
        'cert_of_assumtion_to_duty',
        'supporting_documents',
        'placement_remarks',

        'to_csc_of_rizal',
        'to_csc_of_remarks',
        'turn_around_time',

        'batch_id',
        'job_id'
    ];
}
