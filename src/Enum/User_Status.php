<?php

namespace App\Enum;

enum User_Status: string {
    case active = 'active';
    case banned = 'banned';
}
