<?php

namespace App\Controller;

use App\Controller\IController;
use App\Repository\ClienteRepository;
use App\Model\Cliente;
use Exception;

class IndexController implements IController
{
    public function handleRequest()
    {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }

        $repository = new ClienteRepository();

        if (!$repository) {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao conectar com o banco de dados."]);
            exit(0);
        }

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if (isset($_GET['id'])) {
                    $data = $repository->findById($_GET['id']);
                    if (!$data) {
                        http_response_code(404);
                        echo json_encode(["error" => "Cliente não encontrado."]);
                        exit(0);
                    }
                    echo json_encode($data);
                    exit(0);
                }
                $data = $repository->find();
                echo json_encode($data);
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"));
                if (!$data) {
                    http_response_code(400);
                    echo json_encode(["error" => "Dados inválidos."]);
                    exit(0);
                }
                try {
                    $cliente = $this->parseCliente($data);
                    http_response_code(201);
                    return $repository->insert($cliente);
                }

                catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(["error" => $e->getMessage()]);
                    exit(0);
                }
                break;

            case 'PUT': 
                $data = json_decode(file_get_contents("php://input"));
                if (!$data) {
                    http_response_code(400);
                    echo json_encode(["error" => "Dados inválidos."]);
                    exit(0);
                }
                try {
                    $cliente = $this->parseCliente($data);
                    $id = $data->id;

                    if (!$id) {
                        http_response_code(400);
                        echo json_encode(["error" => "ID não informado."]);
                        exit(0);
                    }

                    if (!$repository->findById($id)) {
                        http_response_code(404);
                        echo json_encode(["error" => "Cliente não encontrado."]);
                        exit(0);
                    }

                    $cliente->setId($id);
                    $repository->update($cliente);
                    http_response_code(200);
                } catch (Exception $e) {
                    http_response_code(400);
                    echo json_encode(["error" => $e->getMessage()]);
                    exit(0);
                }
                break;
            
            case 'DELETE':
                $id = $_GET['id'];
                if (!$id) {
                    http_response_code(400);
                    echo json_encode(["error" => "ID não informado."]);
                    exit(0);
                }
                if (!$repository->findById($id)) {
                    http_response_code(404);
                    echo json_encode(["error" => "Cliente não encontrado."]);
                    exit(0);
                }
                $repository->delete($id);
                http_response_code(200);
                break;

            default:
                http_response_code(405);
                echo json_encode(["error" => "Método não permitido."]);
                break;
        }
    }

    private function parseCliente($data)
    {   
        $nome = $data->nome;
        $email = $data->email;
        $cidade = $data->cidade;
        $estado = $data->estado;

        if (!$nome || !$email || !$cidade || !$estado) {
            throw new Exception("Dados inválidos.");
        }

        $cliente = new Cliente($nome, $email, $cidade, $estado);
        
        return $cliente;
    }
}
