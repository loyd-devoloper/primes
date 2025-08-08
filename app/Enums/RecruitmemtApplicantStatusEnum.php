<?php

namespace App\Enums;

enum RecruitmemtApplicantStatusEnum: string
{
    case PENDING = 'PENDING';
    case VALIDATE = 'VALIDATE';
    case QUALIFIED = 'QUALIFIED';
    case NOT_QUALIFIED = 'NOT QUALIFIED';

}
