<?php

namespace App\Controllers;

use App\Models\Task;

class TasksController
{
    private array $dataTask;

    public function __construct(array $data)
    {
        $this->dataTask = array();
        $this->dataTask['id'] = $data['id'] ?? NULL;
        $this->dataTask['name'] = $data['name'] ?? '';
        $this->dataTask['description'] = $data['description'] ?? '';
        $this->dataTask['status'] = $data['status'] ?? '';
    }

    public function create()
    {
        try {
            $task = new Task($this->dataTask);
            if($task->insert()){
                return "Task added";
            }
            return 'Error';
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function update()
    {
        try {
            $task = new Task($this->dataTask);
            if($task->update()){
                return "Task modified";
            }
            return 'Error';
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function delete($id)
    {
        try {
            $this->dataTask['id'] = $id;
            $task = new Task($this->dataTask);
            if($task->deleted()){
                return "Task deleted";
            }
            return 'Error';
        } catch (\Exception $e) {
            return $e;
        }
    }

    static public function searchForId($id){
        try {
            return json_encode(Task::searchForId($id));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    static public function getAll(){
        try {
            return json_encode(Task::getAll());
        } catch (\Exception $e) {
            return $e;
        }
    }
}