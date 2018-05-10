<?php

namespace Simina\Security\Auth\Traits;

use Simina\Models\User;
use Exception;

trait CookieAuthentication
{
    protected $key = 'remember';

    protected function setRemember($user) {

        list($identifier, $token) = $this->recaller->generate();

        cookie()->set($this->key, $this->recaller->getHashForCookie($identifier, $token));

        $user->update([
            'remember_token' => $this->recaller->getHashForDb($token),
            'token_identifier' => $identifier
        ]);

        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    public function setUserFromCookie() {

        list($identifier, $token) = $this->recaller->splitCookieValue(
            cookie()->get($this->key)
        );

        $user = $this->getUserByIdentifier($identifier);

        if(!$user) {
            
            cookie()->clear($this->key);

            return;
        }

        if(!$this->recaller->validateToken($token, $user->remember_token)) {

            $this->clearRemember($user);

            throw new Exception;
        }

        $this->setUserInSession($user);
    }

    protected function clearRemember($user) {

        $user->update([
            'remember_token'=>null,
            'token_identifier'=>null
        ]);

        $this->entityManager->flush();
    }

    public function hasRemember() {

        return cookie()->get($this->key);
    }

    protected function getUserByIdentifier($identifier) {

        return $this->entityManager->getRepository($this->entity)->findOneBy([
            'token_identifier' => $identifier
        ]);
    }

}