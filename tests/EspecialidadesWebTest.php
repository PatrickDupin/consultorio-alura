<?php

namespace App\Tests;

use \Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \Symfony\Bundle\FrameworkBundle\KernelBrowser;

class EspecialidadesWebTest extends WebTestCase
{
    public function testGaranteQueRequisicaoFalhaSemAutenticacao()
    {
        $client = static::createClient();
        $client->request('GET', '/especialidades');

        self::assertEquals(
            '401',
            $client->getResponse()->getStatusCode()
        );
    }

    public function testeGaranteQueEspecialidadesSaoListadas()
    {
        $client = static::createClient();
        $token = $this->login($client);
        $client->request('GET', '/especialidades', [], [], [
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ]);

        $resposta = json_decode($client->getResponse()->getContent());
        self::assertTrue($resposta->success);
    }

    public function testInsereEspecialidade()
    {
        $client = static::createClient();
        $token = $this->login($client);

        $client->request('POST', '/especialidades', [], [], [
            'CONTENT_TYPE'       => 'application/json',
            'HTTP_AUTHORIZATION' => "Bearer $token"
        ], json_encode([
                'descricao' => 'Teste'
            ])
        );

        self::assertEquals('201', $client->getContent()->getStatusCode());
    }

    private function login(KernelBrowser $client): string
    {
        $client->request('POST', '/login', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
                'username' => 'usuario',
                'password' => '123456'
            ])
        );

        return json_decode(
            $client->getResponse()->getContent()
        )->access_token;
    }
}