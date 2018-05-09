<?php

namespace Simina\Security\Hashing;

class BcryptHasher implements Hasher
{
    public function make($text)
    {
        $hash = password_hash($text, PASSWORD_BCRYPT, $this->options());

        if(!$hash) {

            throw new \RuntimeException('Bcrypt is not support, please switch your php version');
        }

        return $hash;
    }

    public function verify($text, $hash)
    {
        return password_verify($text, $hash);
    }

    public function needsRehash($hash)
    {
        return password_needs_rehash($hash, PASSWORD_BCRYPT, $this->options());
    }

    protected function options()
    {
        return [
            'cost' => 14
        ];
    }
}