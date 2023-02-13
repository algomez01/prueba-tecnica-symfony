<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppCustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        /* //Almacenar el usuario
        $request->getSession()->set("user",$request->getSession()->get(Security::LAST_USERNAME));

        // Redireccionar al dashboard según el rol
        if($this->auth->isGranted(User::ROLE_ADMIN)){
            return new RedirectResponse($this->urlGenerator->generate('app_admin_dashboard'));
        }elseif($this->auth->isGranted(User::ROLE_CAJERO )){
            return new RedirectResponse($this->urlGenerator->generate('app_cajero_dashboard'));
        }elseif($this->auth->isGranted(User::ROLE_MEDICO)){
            return new RedirectResponse($this->urlGenerator->generate('app_medico_dashboard_index'));
        }elseif($this->auth->isGranted(User::ROLE_PACIENTE)){
            return new RedirectResponse($this->urlGenerator->generate('app_paciente_dashboard_index')); */

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        
        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
