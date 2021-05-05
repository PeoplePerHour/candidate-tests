<?php

declare(strict_types=1);

namespace App\Validation;

use Exception;

use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_slice;
use function array_values;
use function call_user_func;
use function is_array;
use function is_callable;

class Validator
{
    private $orig        = [];
    private $data        = [];
    private $defau       = [];
    private $err         = [];
    private $typecasters = [];
    private $validators  = [];

    public function __construct(array $data = [], array $defaults = [], array $typecasters = [], array $validators = [])
    {
        $this->input($data);
        $this->defaults($defaults);
        $this->typecast($typecasters);
        $this->validate($validators);
    }

    public function input(array $data = []) : self
    {
        $this->orig = $data;
        $this->data = $data;
        return $this;
    }

    public function defaults(array $defaults = []) : self
    {
        $this->defau = $defaults;
        return $this;
    }

    public function typecast(array $typecasters = []) : self
    {
        $this->typecasters = $typecasters;
        return $this;
    }

    public function validate(array $validators = []) : self
    {
        $this->validators = $validators;
        return $this;
    }

    public function errors() : array
    {
        return $this->err;
    }

    public function run(bool $all = false) : self
    {
        $this->data = $this->merge($this->orig, $this->defau);
        $this->err  = [];

        foreach ($this->typecasters as $key => $typecaster) {
            if (is_callable($typecaster)) {
                $value = $this->get([$key], $this);

                if ($value !== $this) {
                    $this->data[$key] = call_user_func($typecaster, $value);
                }
            }
        }

        foreach ($this->validators as $key => $validator) {
            if (is_callable($validator)) {
                $valid = true;

                try {
                    call_user_func($validator, '*' === $key ? $this : $this->get([$key], null)); /* wildcard key is for global validation on all data */
                } catch (Exception $e) {
                    $this->err[$key] = $e->getMessage();
                    $valid           = false;
                }

                if (! $valid && ! $all) {
                    break;
                }
            }
        }

        return $this;
    }

    public function get(array $keys = [], /*mixed*/ $default = null, bool $flat = false) /*: mixed*/
    {
        return $this->getVal((array) $keys, $default, $this->data, $flat);
    }

    public function merge(array $array, array $defaults, bool $recursive = true) : array
    {
        foreach ($defaults as $key => $def) {
            if (array_key_exists($key, $array)) {
                if ($recursive && is_array($array[$key]) && is_array($def)) {
                    $array[$key] = $this->merge($array[$key], $def, $recursive);
                }
            } else {
                $array[$key] = $def;
            }
        }

        return $array;
    }

    public function flatten(/*mixed*/ $array) /*: mixed*/
    {
        if (! is_array($array)) {
            return $array;
        }

        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->flatten($value));
            } else {
                $result = array_merge($result, [$key => $value]);
            }
        }

        return $result;
    }

    private function cleanResult(array $data, /*mixed*/ $default, bool $skipNonExist = true) /*: mixed*/
    {
        $keys = array_keys($data);

        $isNotAssociative = $keys === array_keys($keys);

        $skipped = false;

        foreach ($data as $key => $val) {
            if ($this === $val) {
                if ($skipNonExist) {
                    unset($data[$key]);
                    $skipped = true;
                } else {
                    $data[$key] = $default;
                }
            } elseif (is_array($val)) {
                $data[$key] = $this->cleanResult($val, $default, $skipNonExist);
            }
        }

        if ($skipped && $isNotAssociative) {
            $data = array_values($data);
        }

        return $data;
    }

    private function getVal(array $keys, /*mixed*/ $default, /*mixed*/ $current, bool $flat, bool $skipNonExist = true) /*: mixed*/
    {
        $self = $this;

        foreach (array_values($keys) as $i => $key) {
            if (is_array($current)) {
                if ('*' === $key) { /* wildcard key */
                    $restKeys = array_slice($keys, $i + 1);

                    $res = array_map(function ($k) use ($self, $current, $restKeys, $flat, $skipNonExist) {
                        $res = $self->getVal($restKeys, $self, $current[$k], $flat, $skipNonExist);
                        return is_array($res) && empty($res) ? $self : $res;
                    }, array_keys($current));

                    $res = $this->cleanResult($res, $default, $skipNonExist);

                    if (is_array($res) && empty($res)) {
                        return $default;
                    }

                    return $flat ? $this->flatten($res) : $res;
                } elseif (array_key_exists($key, $current)) {
                    $current = $current[$key];
                } else {
                    return $default;
                }
            } else {
                return $default;
            }
        }

        return $current;
    }
}
