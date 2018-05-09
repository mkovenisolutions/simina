<?php

namespace Simina\Security\Hashing;

interface Hasher
{
    function make($text);

    function verify($text, $hash);

    function needsRehash($hash);
}