<?php

namespace Tests;

use App\Models\Task;

require_once('../app/Models/Task.php');

$data = [
    "id" => 2          
];

$task = new Task($data);
if($task->deleted()){
    echo "Task deleted";
}else{
    echo "Error";
}