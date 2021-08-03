<?php

namespace App\Entity;
use MyCLabs\Enum\Enum;


class Role extends Enum
{
    private const USER = 'ROLE_USER';
    private const PAGE_1 = 'ROLE_PAGE_1';
    private const PAGE_2 = 'ROLE_PAGE_2';
    private const ADMIN = 'ROLE_ADMIN';

}
