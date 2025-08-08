<?php
namespace App\Enums;



enum TypeOfLeaveEnum: string
{

    case VACATION_LEAVE = "Vacation Leave";
    case FORCE_LEAVE = "Mandatory/Forced Leave";
    case SICK_LEAVE = "Sick Leave";
    case MATERNITY_LEAVE = "Maternity Leave ";
    case PATERNITY_LEAVE = "Paternity Leave";
    case SPECIAL_PRIVILEGE_LEAVE = "Special Privilege Leave";
    case SOLO_PARENT_LEAVE = "Solo Parent Leave";
    case STUDY_LEAVE = "Study Leave";
    case VAWC_LEAVE = "10-Day VAWC Leave ";
    case REHABILITATION_PRIVILEGE = "Rehabilitation Privilege";
    case SPECIAL_LEAVEL_BENIFITS_FOR_WOMEN = "Special Leave Benefits for Women";
    case SPECIAL_EMERGENCY_CALAMITY_LEAVE = "Special Emergency (Calamity) Leave";
    case ADOPTION_LEAVE = "Adoption Leave";
    case OTHERS = "Others";

    public function leaveType(): string | array | null
    {
        return match ($this) {
            self::VACATION_LEAVE => 'A19',
            self::FORCE_LEAVE => 'A20',
            self::SICK_LEAVE => 'A21',
            self::MATERNITY_LEAVE => 'A22',
            self::PATERNITY_LEAVE => 'A23',
            self::SPECIAL_PRIVILEGE_LEAVE => 'A24',
            self::SOLO_PARENT_LEAVE => 'A25',
            self::STUDY_LEAVE => 'A26',
            self::VAWC_LEAVE => 'A27',
            self::REHABILITATION_PRIVILEGE => 'A28',
            self::SPECIAL_LEAVEL_BENIFITS_FOR_WOMEN => 'A29',
            self::SPECIAL_EMERGENCY_CALAMITY_LEAVE => 'A30',
            self::ADOPTION_LEAVE => 'A31',
            self::OTHERS => 'A32',
        };
    }
}
