<?php

    namespace App\Controllers;

    use CodeIgniter\RESTful\ResourceController;

    class Produtos extends ResourceController {
        private $produtoModel;
        private $token = '123456789abcdefghi';

        public function __construct()
        {
            $this-> produtoModel = new \App\Models\ProdutosModel();
        }

        private function _validaToken()
        {
            return $this-> request -> getHeaderLine('token') == $this -> token;
        }

        // retornar todos os produtos

        public function list()
        {
            $data = $this-> produtoModel -> findAll();

            return $this-> response ->setJSON($data);
        }

        // inserir novo registro

        public function create()
        {
            $response = [];

            // validar o token 
            if($this-> _validaToken() ==true){
                // pegar os dados que vieram no body da requisição para salvar
                $newProduto['nome'] = $this->request-> getPost('nome');
                $newProduto['valor'] = $this->request-> getPost('valor');

                try {
                    if($this -> produtoModel-> insert($newProduto)){
                        // deu certo
                        $response = [
                            'response' => 'success',
                            'msg'      =>  'Produto adicionado com sucesso',
                        ];
                    }
                    else {
                        $response = [
                            'response'  => 'error',
                            'msg'       => 'Error ao salvar produto',
                            'errors'    => $this -> produtoModel-> errors()
                        ];
                    }
                } catch (Exception $e) {
                    //throw $th;
                    $response = [
                        'response'  => 'error',
                        'msg'       => 'Error ao salvar produto',
                        'errors'    => [
                            'Exception'  => $e->getMessage()
                        ]
                    ];
                }
            }
            else {
                $response =[
                    'response' => 'error',
                    'msg' => 'Token invalido',
                ];
            }
            return $this -> response -> setJSON($response);
        }
    }