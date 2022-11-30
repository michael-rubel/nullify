<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/nullify. (https://github.com/michael-rubel/nullify)
 *
 * @link https://github.com/michael-rubel/nullify for the canonical source repository.
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/nullify/main/LICENSE.md MIT
 */

namespace MichaelRubel\Nullify;

/**
 * "Nullify" class to convert empty data of any type to `null`.
 *
 * @author Michael Rubél <michael@laravel.software>
 */
class Nullify
{
    /**
     * Perform the "Nullification". 😁
     *
     * @param  mixed  $values
     * @return mixed
     */
    public static function the(mixed $values): mixed
    {
        return static::nullify($values);
    }

    /**
     * "Nullify" the value or iterable.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected static function nullify(mixed $value): mixed
    {
        if (static::blank($value)) {
            return null;
        }

        if (! is_iterable($value) && ! $value instanceof \ArrayAccess) {
            return $value;
        }

        $output = is_object($value) ? clone $value : [];

        foreach ($value as $key => $nested) {
            $output[$key] = static::nullify($nested);
        }

        return $output;
    }

    /**
     * Determine if the given value is "blank".
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    protected static function blank(mixed $value): bool
    {
        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof \Countable) {
            return count($value) === 0;
        }

        if (is_object($value)) {
            return (object) [] == $value;
        }

        return empty($value);
    }
}