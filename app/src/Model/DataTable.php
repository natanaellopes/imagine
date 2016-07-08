<?php

namespace App\Model;

class DataTable
{

    protected $tableGateway;

    public function __construct(\PDO $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->query("SELECT * FROM `data`")->fetchAll();
    }

    public function find($id)
    {
        return $this->tableGateway->query("SELECT * FROM `data` WHERE `id` = $id")->fetch();
    }

    public function insert($key, $value)
    {
        $stmt = $this->tableGateway->prepare("INSERT INTO `data` SET `key` = :key, `value` = :value");
        $stmt->execute([
            'key' => $key,
            'value' => $value
        ]);
        return $this->tableGateway->lastInsertId();
    }

    public function update($id, $key, $value)
    {
        $stmt = $this->tableGateway->prepare("UPDATE `data` SET `key` = :key, `value` = :value WHERE `id` = :id ");
        return $stmt->execute([
            'id' => $id,
            'key' => $key,
            'value' => $value
        ]);
    }

    public function delete($id)
    {
        return $this->tableGateway->query("DELETE FROM `data` WHERE id = $id");
    }

}