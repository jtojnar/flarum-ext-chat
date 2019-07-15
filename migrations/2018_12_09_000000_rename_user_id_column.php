<?php

use Flarum\Database\Migration;

return Migration::renameColumns('pushedx_messages', ['actorId' => 'user_id']);
