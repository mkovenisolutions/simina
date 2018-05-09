<?php

namespace Simina\Security\Auth;

use Doctrine\ORM\EntityManager;
use Simina\Models\User;
use Simina\Storage\Contracts\StorageInterface;
use Simina\Security\Hashing\Hasher;
use Simina\Security\Auth\Traits\CookieAuthentication;


class Auth
{
    use CookieAuthentication;
    /**
     * The entity manager property
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * password hasher
     *
     * @var \Simina\Security\Hashing\Hasher
     * 
     */

     protected $hasher;

    /**
     * Cookie Recaller
     *
     * @var CookieRecaller
     */
    protected $recaller;

    /**
     * initializes the hasher, recaller and entity manager properties
     *
     * @param \Doctrine\ORM\EntityManagerEntityManager $entityManager
     * @param \Simina\Security\Hashing\Hasher $hasher
     * @param \Simina\Security\Recaller
     */

     protected $sessionKey = 'id';

     protected $user;

    public function __construct(EntityManager $entityManager, Hasher $hasher, CookieRecaller $recaller)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
        $this->recaller = $recaller;

    }

    /**
     * authenticates the user by their username and password
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function attempt(string $email, string $password, $remember = false) {

        $user = $this->findUserByEmail($email);

        if(!$user || !$this->isValidUser($user, $password)) {

            return false;
        }

        if($this->requiresRehash($user->password)) {

            $this->updateUserHash($user, $password);
        }

        $this->setUserInSession($user);

        if($remember) {

            $this->setRemember($user);
        }
        return true;
        
    }

    public function check()
    {
        return $this->hasUserInSession();
    }

    protected function isValidUser($user, $password) {

        return $this->hasher->verify($password, $user->password);
    }

    protected function requiresRehash($hash) {

        return $this->hasher->needsRehash($hash);
    }

    protected function updateUserHash($user, $password) {

        $user->password = $this->hasher->make($password);
    }

    public function hasUserInSession() {
        
        return session()->has($this->sessionKey);
    }

    public function setUserFromSession() {

        $user = $this->findUserById(session()->get($this->sessionKey));

        
        if(!$user) {

            throw new \Exception;
        }

        $this->user = $user;
    }

    protected function setUserInSession($user) {

        session()->set($this->sessionKey, $user->id);
    }

    public function user() {

        return $this->user;
    }

    protected function findUserById($id)
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    protected function findUserByEmail($email) {

        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
    }


    public function logout() {

        $this->clearRemember(auth()->user());

        session()->clear($this->sessionKey);
    }
    

}