<?php

namespace Models\DBAL\ParameterType;

final class ParameterType
{
    public const NULL = 0;

    public const INTEGER = 1;

    public const STRING = 2;

    public const BOOL = 5;

    public const BINARY = 16;

    public const LARGE_OBJECT = 3;

    public function __construct()
    {
    }
}
