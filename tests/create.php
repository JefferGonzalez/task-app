<?php

namespace Tests;

use App\Models\Task;

require_once('../app/Models/Task.php');

$data = [
    "id" => null,
    "name" => "First Task",
    "description" => "Hello World",
    "status" => "To Do",            
];

$task = new Task($data);
if($task->insert()){
    echo "Task added";
}else{
    echo "Error";
}