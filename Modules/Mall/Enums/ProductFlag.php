<?php

namespace Modules\Mall\Enums;

use BenSampo\Enum\Enum;

final class ProductFlag extends Enum
{
    const Inactive = 0;
    const Active = 1;
    const Archived = 2;
    const Hot = 3;
}