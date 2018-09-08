<?php

namespace Model;

require_once __DIR__ . '/dataMysql.php';

Interface IAction
{
    function run();

    //function test(...$var);
}