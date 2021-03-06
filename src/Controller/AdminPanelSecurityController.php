<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminPanelSecurityController
 * @package App\Controller
 * Clase generado por symfony.
 */
class AdminPanelSecurityController extends AbstractController
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @Route("/admin/login", name="app_login")
     */
    public function loginTemplate(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        if ($referer = $request->headers->get('referer')) {
           $referer_arr = explode('/', $referer);
           if ( $referer_arr[count($referer_arr) - 1]  === 'registrar') {
               return new RedirectResponse('/cliente');
           }
        }
        
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        $email = $authenticationUtils->getLastUsername();
        

        return $this->render('/admin/login/index.html.twig', ['email_anterior' => $email, 'error' => $error]);
    }

    /**
     * @Route("/admin/logout", name="app_logout")
     */
    public function logout()
    {
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
