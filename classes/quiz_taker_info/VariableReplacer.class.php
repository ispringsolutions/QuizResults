<?php

class VariableReplacer
{
    private $values;
    private $pattern;

    public function __construct($replacements)
    {
        $this->values = $this->buildValueByVariableMap($replacements);
        $this->pattern = $this->buildPattern($replacements);
    }

    public function replace($subject)
    {
        return preg_replace_callback(
            $this->pattern,
            array($this, 'replaceSingleMatch'),
            $subject
        );
    }

    private function buildValueByVariableMap($replacements)
    {
        $result = array();
        foreach ($replacements as $variable => $value)
        {
            $hash = $this->normalizeVariable($variable);
            $result[$hash] = $value;
        }
        return $result;
    }

    private function normalizeVariable($variable)
    {
        return strtoupper($variable);
    }

    private function buildPattern($replacements)
    {
        $variables = array_keys($replacements);
        $variables = $this->escapeForPattern($variables);
        return '~%(' . implode('|', $variables) . ')%~i';
    }

    private function escapeForPattern($variables)
    {
        return array_map(
            function ($variable) { return preg_quote($variable, '~'); },
            $variables
        );
    }

    private function replaceSingleMatch($matches)
    {
        $variable = $this->normalizeVariable($matches[1]);
        return !empty($this->values[$variable])
            ? $this->values[$variable]
            : '';
    }
}