<?php

namespace SharedKernel\ConfigResolver;

class Environment
{
    public function findByKey(string $key, mixed $default = null)
    {
        return env($key, $default);
    }
}

