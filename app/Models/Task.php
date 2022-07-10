<?php

namespace App\Models;

use App\Models\AbstractConnection;
use App\Interfaces\Model;
use App\Enums\Status;
use Exception;

require_once('AbstractConnection.php');
require_once(__DIR__.'/../Enums/Status.php');
require_once(__DIR__.'/../Interfaces/Model.php');

class Task extends AbstractConnection implements Model
{
    private ?int $id;
    private string $name;
    private string $description;
    private Status $status;

    public function __construct(array $task = [])
    {
        parent::__construct();
        $this->setId($task['id'] ?? null);
        $this->setName($task['name'] ?? '');
        $this->setDescription($task['description'] ?? '');
        $this->setStatus((empty($task['status'])) ? Status::ToDo : $task['status']);
    }
    
    function __destruct()
    {
        if($this->isConnected()){
            $this->Disconnect();
        }
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): string
    {
        return $this->status->toString();
    }

    /**
     * Set the value of status
     */
    public function setStatus(null|string|Status $status)
    {
        if(is_string($status)){
            $this->status = Status::from($status);
        }else{
            $this->status = $status;
        }
    }

    protected function save(string $query): ?bool
    {
        $params = [
            ':id' => $this->getId(),
            ':name' => $this->getName(),
            ':description' => $this->getDescription(),
            ':status' => $this->getStatus(),
        ];
        $this->Connect();
        $result = $this->executeQuery($query, $params);
        $this->Disconnect();
        return $result;
    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO task (id,name,description,status) VALUES (:id,:name,:description,:status)";
        return $this->save($query);
    }

    public function update(): ?bool
    {
        $query = "UPDATE task SET name = :name , description = :description , status = :status WHERE id = :id";
        return $this->save($query);
    }

    public function deleted(): ?bool
    {
        $query = "DELETE FROM task WHERE id = :id";
        $this->Connect();
        $result = $this->executeQuery($query, array(":id" => $this->getId()));
        $this->Disconnect();
        return $result;
    }

    public static function search($query): ?array
    {
        try {
            $array = array();
            $task = new Task();
            $task->Connect();
            $getrows = $task->getRows($query);
            $task->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Task = new Task($valor);
                    array_push($array, $Task);
                    unset($Task);
                }
                return $array;
            }
            return null;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return null;
    }

    public static function searchForId(int $id): ?Task
    {
        if ($id > 0) {
            $task = new Task();
            $task->Connect();
            $getrow = $task->getRow("SELECT * FROM task WHERE id =?", array($id));
            $task->Disconnect();
            return ($getrow) ? new Task($getrow) : null;
        } else {
            return "Id invalid";
        }
        return null;
    }

    public static function getAll(): ?array
    {
        return Task::search("SELECT * FROM task");
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
        ];
    }

}