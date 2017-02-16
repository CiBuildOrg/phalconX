<?php
namespace Engine\Api;

interface SessionInterface
{
    public function encode($token);
    public function decode($token);
    public function create($issuer, $user, $iat, $exp);
}
