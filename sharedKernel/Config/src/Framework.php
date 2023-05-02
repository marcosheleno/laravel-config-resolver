<?php

namespace SharedKernel\ConfigResolver;

class Framework
{
    public function findByKey(string $key, mixed $default = null)
    {
        return config($key, $default);
    }
}

