<?php

/**
 * Define the admin login form authentificator guard. Guard that controls all the authentification steps.
 *
 * @author    Damien DE SOUSA <email@email.com>
 * @copyright 2020 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Security\Admin;

use App\Entity\User;
use App\Security\UserRoles;
use App\Controller\Admin\Index;
use App\Security\Admin\AuthSecurizer;
use App\Controller\Admin\Security\Login;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\Security\LoginCheck;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    protected EntityManagerInterface $entityManager;

    protected UrlGeneratorInterface $urlGenerator;

    protected CsrfTokenManagerInterface $csrfTokenManager;

    protected UserPasswordEncoderInterface $passwordEncoder;

    protected \App\Security\Admin\AuthSecurizer $authSecurizer;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder,
        AuthSecurizer $authSecurizer
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->authSecurizer = $authSecurizer;
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        return LoginCheck::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('_username'),
            'password' => $request->request->get('_password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );

        return $credentials;
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials['username']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Username could not be found.');
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $isUserAdmin = false;
        if ($this->authSecurizer->isGranted($user, UserRoles::ROLE_ADMIN)) {
            $isUserAdmin = true;
        }

        return $isUserAdmin && $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * @inheritDoc
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }
        $adminDefaultUrl = $this->urlGenerator->generate(Index::INDEX_ROUTE);

        return new RedirectResponse($adminDefaultUrl);
    }

    /**
     * @inheritDoc
     */
    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate(Login::LOGIN_PAGE_ROUTE);
    }
}
