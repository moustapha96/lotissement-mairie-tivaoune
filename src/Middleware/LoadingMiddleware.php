<?php

namespace App\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class LoadingMiddleware
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        // Créer une réponse HTTP vide avec l'indicateur de chargement
        $content = $this->twig->render('loading/loading.html.twig');
        $response = new Response($content);

        // Définir la réponse pour l'événement
        $event->setResponse($response);
    }
}
