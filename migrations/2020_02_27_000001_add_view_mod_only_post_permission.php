<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

use Flarum\Group\Group;
use Illuminate\Database\Schema\Builder;

$rows = [
    ['permission' => 'discussion.viewModOnly', 'group_id' => Group::MODERATOR_ID],
];

return [
    'up' => function (Builder $schema) use ($rows) {
        $db = $schema->getConnection();

        foreach ($rows as $row) {
            if ($db->table('groups')->where('id', $row['group_id'])->doesntExist()) {
                continue;
            }

            if ($db->table('group_permission')->where($row)->doesntExist()) {
                $db->table('group_permission')->insert($row);
            }
        }
    },

    'down' => function (Builder $schema) use ($rows) {
        $db = $schema->getConnection();

        foreach ($rows as $row) {
            $db->table('group_permission')->where($row)->delete();
        }
    }
];
