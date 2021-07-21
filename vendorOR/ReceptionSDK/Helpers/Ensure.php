<?php

namespace ReceptionSDK\Helpers;
use DateTime;
use InvalidArgumentException;

/**
 * Utility class to check parameters
 * @package ReceptionSDK\Helpers
 */
class Ensure
{

    /**
     * Checks an argument to ensure it isn't null.
     * @param mixed $value The argument value to check
     * @param string $name The name of the argument
     */
    public static function argumentNotNull($value, $name)
    {
        if (is_null($value)) {
            throw new InvalidArgumentException("Argument ${name} can not be null");
        }
    }

    /**
     * Checks a string argument to ensure it isn't null or empty.
     * @param string $value The argument value to check
     * @param string $name The name of the argument
     */
    public static function argumentNotNullOrEmptyString($value, $name)
    {
        self::argumentNotNull($value, $name);

        if (empty($value)) {
            throw new InvalidArgumentException("Argument ${name} can not be empty");
        }
    }

    /**
     * Checks a double argument to ensure it is a positive value.
     * @param double $value The argument value to check
     * @param string $name The name of the argument
     */
    public static function greaterThanZero($value, $name)
    {
        if (!(is_integer($value) || is_double($value))) {
            throw new \InvalidArgumentException("$name must be greater than zero");
        }

        if ($value < 0) {
            throw new \InvalidArgumentException("$name must be greater than zero");
        }
    }

    /**
     * Checks a long argument to ensure it is a positive value or zero.
     * @param double $value The argument value to check
     * @param string $name The name of the argument
     */
    public static function greaterOrEqualsThanZero($value, $name)
    {
        if (!(is_integer($value) || is_double($value))) {
            throw new \InvalidArgumentException("$name must be greater or equals than zero");
        }

        if ($value < 0) {
            throw new \InvalidArgumentException("$name must be greater or equals than zero");
        }
    }

    /**
     * Checks that a date has a valid format
     * @param $value
     * @param $name
     * @param string $format
     */
    public static function validDateFormat($value, $name, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $value);
        $valid = ($d && $d->format($format) == $value);
        if (!$valid) {
            throw new InvalidArgumentException("$name has an invalid format. The correct one is '$format'");
        }
    }

    /**
     * Check that first date is before second date
     * @param $first
     * @param $second
     * @param $firstName
     * @param $secondName
     */
    public static function firstDateBeforeSecond($first, $second, $firstName, $secondName)
    {
        if (strtotime($second) <= strtotime($first)) {
            throw new InvalidArgumentException("$firstName must be before than $secondName");
        }
    }

}