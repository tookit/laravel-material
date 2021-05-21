<?php

namespace Modules\PMS\Enum;

use BenSampo\Enum\Enum;

final class TaskStatus extends Enum {

    const TODO = 0;
    const PROGRESSING = 1;
    const TEST = 2;
    const DONE = 3;

}