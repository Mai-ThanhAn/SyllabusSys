<?php

namespace App\Enums;

enum RoleName: string
{
    case SUPERADMIN = 'Superadmin';
    case UNIVERSITY_ADMIN = 'University_Admin';
    case PROGRAM_DIRECTOR = 'Program_Director';
    case LECTURER = 'Lecturer';
    case GUEST = 'Guest';
}
