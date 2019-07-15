<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('pushedx_messages', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('set null');;
        });
    },
    'down' => function (Builder $schema) {
        $schema->table('pushedx_messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
];
