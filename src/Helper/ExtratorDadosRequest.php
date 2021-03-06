<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class ExtratorDadosRequest
{
    private function buscaDadosRequest(Request $request)
    {
        $queryString = $request->query->all();

        $dadosOrdenacao = array_key_exists('sort', $queryString)
            ? $queryString['sort']
            : null;
        unset($queryString['sort']);

        $paginaAtual = array_key_exists('page', $queryString)
            ? $queryString['page']
            : 1;
        unset($queryString['page']);

        $itensPorPagina = array_key_exists('itensPorPagina', $queryString)
            ? $queryString['itensPorPagina']
            : 5;
        unset($queryString['itensPorPagina']);

        return [$queryString, $dadosOrdenacao, $paginaAtual, $itensPorPagina];
    }

    public function buscaDadosOrdenacao(Request $request)
    {
        list( , $ordenacao) = $this->buscaDadosRequest($request);

        return $ordenacao;
    }

    public function buscaDadosFiltro(Request $request)
    {
        /*
         * A partir do PHP 7, temos uma sintaxe nova para essa operação. Ao invés de escrevermos a função list(),
         * podemos simplesmente informar que estamos recebendo os dados de um array da seguinte forma:
         * */
        [$filtro, ] = $this->buscaDadosRequest($request);

        return $filtro;
    }

    public function buscaDadosPaginacao(Request $request)
    {
        [ , , $paginaAtual, $itensPorPagina] = $this->buscaDadosRequest($request);

        return [$paginaAtual, $itensPorPagina];
    }
}