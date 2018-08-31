<?php

namespace Dareen\Support;

trait ValueConverter
{
    /**
     * Convert the value to its respective representation in string.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function convertValue($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_null($value)) {
            return 'null';
        }

        if (is_numeric($value)) {
            return $value;
        }

        if (is_string($value)) {
            return "'{$value}'";
        }

        if (is_array($value)) {
            $convertedValues = array_map(function ($value) {
                return $this->convertValue($value);
            }, $value);

            return '[' . implode(', ', $convertedValues) . ']';
        }

        return '';
    }
}
