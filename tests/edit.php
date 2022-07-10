<?php

namespace Tests;

use App\Models\Task;

require_once('../app/Models/Task.php');

$data = [
    "id" => 1,
    "name" => "First Task",
    "description" => "Hello World",
    "status" => "Doing",            
];

$task = new Task($data);
if($task->update()){
    echo "Task updated";
}else{
    echo "Error";
}