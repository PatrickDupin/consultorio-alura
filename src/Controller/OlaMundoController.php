<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OlaMundoController
{
    /**
     * @Route("/ola")
     */
    public function OlaMundoAction(Request $request) : Response
    {
        $pathInfo = $request->getPathInfo();
        /*
         * Os parametros da url podem ser acessados individualmente dessa maneira:
         * $parametro = $request->query->get('parametro');
         *
         * ou também podem ser acessados todos os parametros da query como abaixo
         */
        $query = $request->query->all();

        return new JsonResponse([
            'mensagem' => 'Olá Mundo!',
            'pathInfo' => $pathInfo,
            'query' => $query
        ]);
    }

}