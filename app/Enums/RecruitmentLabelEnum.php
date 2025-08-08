<?php

namespace App\Enums;

enum RecruitmentLabelEnum: string
{
    case LETTER_OF_INTENT = 'Letter of intent addressed to the Regional Director. Please include the position and its item number with corresponding Functional Division/Section/Unit';
    case PDS = 'Duly accomplished Personal Data Sheet(PDS) and Work Experience Sheet with recent passport-sized picture (CS Form No. 212, Revised 2017) which can be downloaded at www.csc.gov.ph.';
    case PRC = 'Photocopy of valid and updated PRC License/ID or Photocopy of Certificate of Eligibility/Rating (if applicable)';

    // case ELIGIBILITY = 'Photocopy of Certificate of Eligibility/Rating (if applicable)';

    case TOR = 'Photocopy of scholastic/academic recored such as but not limited to Transcript of Records (TOR) and Diploma, including completion of graduate and post-graduate units/degrees (if applicable)';

    case TRAINING_ATTENDED = 'Photocopy of Certificate/s of Training attended';

    case CERTIFICATE_OF_EMPLOYMENT = 'Photocopy of Certificate of Employment, Contract of Service, or duly signed Service Record, whichever is/are applicable';

    case LATEST_APPOINTMENT = 'Photocopy of latest appointment (if applicable)';

    case PERFORMANCE_RATING = 'Photocopy of the Performance Rating in the last rating period(s) covering one (1) year performance in the current/latest position prior to the deadline of submission(if applicable)';

    case CAV = 'Checklist of Requirements and Omnibus Sworn Statement on the Certification on the Authenticity and Veracity (CAV) of the documents submitted and Data Privacy Consent Form pursuant to RA No. 10173 (Data Privacy Act of 2012), using the form (Annex C) of DepEd Order No. 007, s. 2023, notarized by authorized official';

    case MOVS = 'Means of Verification (MOVS) showing Outstanding Accomplishment, Application of Education, and Application of Learning and Development reckoned from the date of last issurance of appointment.';

    case AWARDS_AND_RECOGNITION = 'Awards & Recognition';

    case RESEARCH_AND_INNOVATION = 'Research & Innovation';

    case MEMBERSHIP_IN_NATIONAL = 'Subject Matter Expert / Membership in national TWGs or Committees';

    case RESOURCE_AND_SPEAKERSHIP = 'Resource Speakership / Learning facilitation';

    case NEAP = 'NEAP Accredited learning Falicitator';

    case APPLICATION_OF_EDUCATION = 'Application of Education';

    case LEARNING_AND_DEVELOPMENT = 'Application of learning & Development';
    public function getLabel(): string | array | null
    {


        return match ($this) {
            self::LETTER_OF_INTENT => 'EMPTY',
            self::PDS => 'INCOMPLETE',
            self::PRC => 'COMPLETE',

        };
    }
    public function getColumn(): string | array | null
    {


        return match ($this) {
            self::LETTER_OF_INTENT => 'letter_of_intent',
            self::PDS => 'pds',
            self::PRC => 'prc',
            self::TOR => 'tor',
            self::TRAINING_ATTENDED => 'training_attended',
            self::CERTIFICATE_OF_EMPLOYMENT => 'certificate_of_employment',
            self::LATEST_APPOINTMENT => 'latest_appointment',
            self::PERFORMANCE_RATING => 'performance_rating',
            self::CAV => 'cav',
            self::AWARDS_AND_RECOGNITION => 'awards_recognition',
            self::RESEARCH_AND_INNOVATION => 'research_innovation',
            self::MEMBERSHIP_IN_NATIONAL => 'membership_in_national',
            self::RESOURCE_AND_SPEAKERSHIP => 'resource_speakership',
            self::NEAP => 'neap',
            self::APPLICATION_OF_EDUCATION => 'application_of_education',
            self::LEARNING_AND_DEVELOPMENT => 'l_and_d',
            self::MOVS => 'movs',

        };
    }

    public function shortName(): string | array | null
    {


        return match ($this) {
            self::LETTER_OF_INTENT => 'Letter of Intent',
            self::PDS => 'Personal Data Sheet (PDS) and Work Experience Sheet (WES)',
            self::PRC => 'PRC ID/Certificate of Eligibility',
            self::TOR => 'Transcript of Records (TOR) and Diploma',
            self::TRAINING_ATTENDED => 'Certificate of Trainings attended',
            self::CERTIFICATE_OF_EMPLOYMENT => 'Certificate of Employment (COE), Contracts, or Service Record',
            self::LATEST_APPOINTMENT => 'Latest Appointment',
            self::PERFORMANCE_RATING => 'Performance Rating',
            self::CAV => 'Checklist of Requirements and Omnibus Sworn Statement',
            self::AWARDS_AND_RECOGNITION => 'Awards & Recognition',
            self::RESEARCH_AND_INNOVATION => 'Research & Innovation',
            self::MEMBERSHIP_IN_NATIONAL => 'Subject Matter Expert/ TWGs',
            self::RESOURCE_AND_SPEAKERSHIP => 'Resource Speakership/Learning Facilitation',
            self::NEAP => 'NEAP Accredited learning Falicitator',
            self::APPLICATION_OF_EDUCATION => 'Application of Education',
            self::LEARNING_AND_DEVELOPMENT => 'Application of L & D',

        };
    }
}
