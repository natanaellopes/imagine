<?php

namespace App\Controller;

use App\Model\DataTable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator;

class DataController
{

    protected $db;
    protected $dataGateway;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function create(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getParsedBody();

        $key = filter_var($data['key'], FILTER_SANITIZE_STRING);
        $value = filter_var($data['value'], FILTER_SANITIZE_STRING);

        if(!$this->validate($key, $value)) {
            return $response->withJson(['error' => 'Missing parameters'], 400);
        }

        $dataId = $this->getDataGateway()->insert($key, $value);

        $current = $this->getDataGateway()->find($dataId);

        return $response->withJson([
            'id' => (int)$current->id,
            'key' => $current->key,
            'value' => $current->value,
        ], 201);
    }

    public function read(RequestInterface $request, ResponseInterface $response)
    {
        $query = $this->getDataGateway()->fetchAll();

        $data = [];

        foreach ($query as $q) {
            $data[] = [
                'id' => (int)$q->id,
                'key' => $q->key,
                'value' => $q->value,
            ];
        }

        return $response->withJson($data);
    }

    public function update(RequestInterface $request, ResponseInterface $response, $args)
    {
        $data = $request->getParsedBody();

        $id = $args['id'];

        $current = $this->getDataGateway()->find($id);

        if(!$current) {
            return $response->withJson(['message' => 'data not found'], 400);
        }

        $key = filter_var($data['key'], FILTER_SANITIZE_STRING);
        $value = filter_var($data['value'], FILTER_SANITIZE_STRING);

        if(!$this->validate($key, $value)) {
            return $response->withJson(['error' => 'Missing parameters'], 400);
        }

        $this->getDataGateway()->update($id, $key, $value);

        $current = $this->getDataGateway()->find($id);

        return $response->withJson([
            'id' => (int)$current->id,
            'key' => $current->key,
            'value' => $current->value,
        ]);
    }

    public function delete(RequestInterface $request, ResponseInterface $response, $args)
    {
        $id = $args['id'];

        $current = $this->getDataGateway()->find($id);

        if(!$current) {
            return $response->withJson(['message' => 'data not found'], 400);
        }

        $this->getDataGateway()->delete($id);
        return $response->withJson(['message' => 'deleted'], 204);
    }

    private function validate($key, $value)
    {
        $keyValidation = Validator::stringType()->notEmpty();
        $valueValidation = Validator::stringType()->notEmpty();

        return ($keyValidation->validate($key) && $valueValidation->validate($value));
    }

    private function getDataGateway()
    {
        if (!$this->dataGateway) {
            $this->dataGateway = new DataTable($this->db);
        }
        return $this->dataGateway;
    }

}