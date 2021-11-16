<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
        UserRepository $repository,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->repository = $repository;
        $this->encoder = $encoder;
    }

    /**
     * @Route("/login", name="login")
     */
    public function index(Request $request): Response
    {
        $dadosEmJson = json_decode($request->getContent());

        if ($dadosEmJson === false) {
            throw new AuthenticationException('Dados inválidos');
        }

        $user = $this->repository->findOneBy(['username' => $dadosEmJson->usuario]);
        if (is_null($user)) {
            throw new AuthenticationException('Usuário inválido');
        }

        if (!$this->encoder->isPasswordValid($user, $dadosEmJson->senha)) {
            throw new AuthenticationException('Usuário ou senha inválidos');
        }

        $token = JWT::encode(['username' => $user->getUserIdentifier()],'chave','HS256');
        return new JsonResponse([
            'access_token' => $token
        ]);
    }
}
