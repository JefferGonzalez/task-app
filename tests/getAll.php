<?php

namespace Tests;

use App\Models\Task;

require_once('../app/Models/Task.php');

$task = Task::getAll();
var_dump($task);