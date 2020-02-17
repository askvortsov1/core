<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Install\Steps;

use Flarum\Group\Group;
use Flarum\Install\StructureSkeleton;
use Flarum\Install\Step;

class SwitchSkeletonToShared implements Step
{
    public function getMessage()
    {
        return 'Switching skeleton to shared mode';
    }

    public function run()
    {
        StructureSkeleton::enableShared();
    }
}
