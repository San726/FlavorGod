<?php

namespace Flavorgod\Traits;

use OutOfRangeException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Collection;
use Flavorgod\Libraries\Luhn;
use Log;

trait MarshallsInputs
{

    private $validationRules = [];
    private $validationMessages = [
        'required'      => 'Required field is missing.',
        'alpha'         => 'Field must be entirely alphabetic characters.',
        'alpha_dash'    => 'Field must be alphanumeric, dash, or underscore characters.',
        'alpha_num'     => 'Field must be entirely alphanumeric characters.',
        'email'         => 'Field must be an email address.',
        'integer'       => 'Field must be an integer.',
        'decimal'       => 'Field must be a decimal.',
        'numeric'       => 'Field must be a numeric value.',
        'min'           => 'Field must be at least %s.',
        'minlen'        => 'Field must be at least %s characters in length.',
        'mincount'      => 'Field must contain at least %s items.',
        'max'           => 'Field must be at most %s.',
        'maxlen'        => 'Field must be at most %s characters in length.',
        'maxcount'      => 'Field must contain at most %s items.',
        'between'       => 'Field must be between %s and %s.',
        'betweenlen'    => 'Field must be between %s and %s characters in length.',
        'betweencount'  => 'Field must contain between %s and %s items.',
        'size'          => 'Field must be exactly %s.',
        'strlen'        => 'Field must be exactly %s characters in length.',
        'count'         => 'Field must contain exactly %s items.',
        'array'         => 'Field must be an array.',
        'card'          => 'Field must be a credit card number.'
    ];

    /**
     * Set the value of an element in an array or nested array
     *
     * @param array     &$arr   Array to traverse
     * @param string    $path   Dot notation object path to inspect
     * @param mixed     $value  Value to set at object path
     * @param bool      [$mustExist = false] Throw error if path doesn't exist
     *
     */
    private function setArrayPath(array &$arr, $path, $value, $mustExist = false)
    {
        $next = &$arr;
        $steps = explode('.', $path);
        foreach ($steps as $step) {
            if ($mustExist && !isset($next[$step])) {
                throw new OutOfRangeException('Index '.$step.' does not exist in array.', 0);
            }

            $next = &$next[$step];
        }

        $next = $value;
    }

    /**
     * Get the value of an element in an array or nested array
     *
     * @param array     &$arr   Array to traverse
     * @param string    $path   Dot notation object path to inspect
     * @param bool      [$mustExist = false] Throw error if path doesn't exist
     *
     */
    private function getArrayPath(array &$arr, $path, $mustExist = false)
    {
        $next = &$arr;
        $steps = explode('.', $path);
        foreach ($steps as $step) {
            if ($mustExist && !isset($next[$step])) {
                throw new OutOfRangeException('Index '.$step.' does not exist in array.', 0);
            } elseif (!isset($next[$step])) {
                return null;
            } else {
                $next = &$next[$step];
            }
        }
        return $next;
    }

    /**
     * Method for enforcing and validating marshall rules
     * This method is recursive
     *
     * @param array     $input      Array to marshall
     * @param array     $rules      Rules to enforce
     * @param array     &$messages  Validation error messages to apply
     * @param string    [$prefix = ''] Prefix applied to error field names
     *                                  used specifically for recursive calls
     *
     * @return array    Marshalled result
     *
     */
    private function enforce(array $input, array $rules, array &$messages, $prefix = '')
    {
        $result = [];
        $errors = new MessageBag;
        foreach($rules as $field => $ruleset) {
            $newField = $field;
            $value = $this->getArrayPath($input, $field);
            $validators = is_array($ruleset) ? $ruleset : explode('|', $ruleset);
            foreach($validators as $index => $validator) {
                // If index is an not an integer
                // Then validator is in a method => params format
                // Else validator is delimited string format
                if (!is_integer($index) || is_string($index)) {
                    $method = $index;
                    $params = $validator;
                } else {
                    $params = explode(':', $validator);
                    $method = array_shift($params);
                    if (null !== ($params = array_shift($params))) {
                        $params = is_array($params) ? $params : explode(',', $params);
                    } else {
                        $params = [];
                    }

                }

                $valid = true;
                // Validate items via method
                switch ($method) {
                    case 'required':
                        if ('strict' == @$params[0]) {
                            $valid = isset($value);
                        } else {
                            $valid = !empty($value);
                        }
                        break;
                    case 'alpha':
                        $valid = is_string($value) && preg_match('/a-z/i', $value);
                        break;
                    case 'alpha_dash':
                        $valid = is_string($value) && preg_match('/a-z0-9\\_\\-/i', $value);
                        break;
                    case 'alpha_num':
                        $valid = is_string($value) && preg_match('/a-z0-9/i', $value);
                        break;
                    case 'email':
                        $valid = is_string($value) && preg_match("/^[-a-z0-9~!$%^&*_=+}{\\'?]+(\\.[-a-z0-9~!$%^&*_=+}{\\'?]+)*@([a-z0-9_][-a-z0-9_]*(\\.[-a-z0-9_]+)*\\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}))(:[0-9]{1,5})?$/i", $value);
                        break;
                    case 'int':
                        $method = 'integer';
                    case 'integer':
                        $valid = is_integer($value);
                        break;
                    case 'float':
                    case 'double':
                        $method = 'decimal';
                    case 'decimal':
                        $valid = is_double($value);
                        break;
                    case 'numeric':
                        $valid = is_numeric($value);
                        if (isset($params[0]) && is_string($params[0])) {
                            switch ($params[0]) {
                                case 'int':
                                case 'integer':
                                    $value = (int) $value;
                                    break;
                                case 'float':
                                case 'double':
                                case 'decimal':
                                    $value = (double) $value;
                                    break;
                            }
                        }
                        break;
                    case 'min':
                    case 'minlen':
                    case 'mincount':
                        $valid = false;
                        if (is_string($value) && strlen($value) < (int) $params[0]) {
                            $method = 'minlen';
                        } elseif (is_numeric($value) && $value < (double) $params[0]) {
                            $method = 'min';
                        } elseif (is_array($value) && count($value) < (int) $params[0]) {
                            $method = 'mincount';
                        } else {
                            $valid = true;
                        }
                        break;
                    case 'max':
                    case 'maxlen':
                    case 'maxcount':
                        $valid = false;
                        if (is_string($value) && strlen($value) > (int) $params[0]) {
                            $method = 'maxlen';
                        } elseif (is_numeric($value) && $value > (double) $params[0]) {
                            $method = 'max';
                        } elseif (is_array($value) && count($value) > (int) $params[0]) {
                            $method = 'maxcount';
                        } else {
                            $valid = true;
                        }
                        break;
                    case 'between':
                        $valid = false;
                        if (is_string($value) && (strlen($value) < (int) $params[0] || strlen($value) > (int) $params[1])) {
                            $method = 'betweenlen';
                        } elseif (is_integer($value) && ($value < (double) $params[0] || $value > (double) $params[1])) {
                            $method = 'between';
                        } elseif (is_array($value) && (count($value) < (int) $params[0] || count($value) > (int) $params[1])) {
                            $method = 'betweencount';
                        } else {
                            $valid = true;
                        }
                        break;
                    case 'size':
                        $valid = false;
                        if (is_string($value) && strlen($value) !== (int) $params[0]) {
                            $method = 'strlen';
                        } elseif (is_integer($value) && $value !== (int) $params[0]) {
                            $method = 'size';
                        } elseif (is_array($value) && count($value) !== (int) $params[0]) {
                            $method = 'count';
                        } else {
                            $valid = true;
                        }
                        break;
                    case 'nullifempty':
                    case 'nie':
                        $value = empty($value) ? null : $value;
                        break;
                    case 'optional':
                        if (!isset($value) || empty($value)) {
                            if (count($params) === 2) {
                                $value = $params[1];
                                settype($value, $params[0]);
                            } elseif (count($params) === 1) {
                                if (preg_match('/^@(.*)$/', $params[0], $matches)) {
                                    $value = $this->getArrayPath($input, $matches[1]);
                                } elseif (preg_match('/^#(.*)$/', $params[0], $matches)) {
                                    $value = $this->getArrayPath($result, $matches[1]);
                                } else {
                                    $value = $params[0];
                                }
                            } else {
                                $newField = '';
                            }
                        }
                        break;
                    case 'uppercase':
                            $value = strtoupper($value);
                        break;
                    case 'rename':
                        if (is_string($params[0])) {
                            $newField = $params[0];
                        }
                        break;
                    case 'transform':
                        if (!is_array($params)) {
                            $newField = null;
                        } elseif ($params[0] instanceof \Closure) {
                            $fn = array_shift($params);
                            array_unshift($params, $value);
                            $value = call_user_func_array($fn, $params);
                        } else {
                            $value = $params[0];
                        }
                        break;
                    case 'array':
                        if (!is_array($value)) {
                            $valid = false;
                        } elseif (count($params)) {
                            $vals = [];
                            foreach ($value as $idx => $val) {
                                $val = $this->enforce($val, $validator, $messages, $field.'['.$idx.'].');
                                if (count($val)) {
                                    $vals[] = $val;
                                }
                            }
                            $value = $vals;
                        }
                        break;
                    case 'regex':
                        if (!is_string($value)) {
                            $valid = false;
                        } elseif (count($params) === 2) {
                            $value = preg_replace($params[0], $params[1], $value);
                        } elseif (count($params) === 1) {
                            $valid = preg_match($params[0], $value);
                        }
                        break;
                    case 'enum':
                        $valid = preg_match('('.preg_quote(implode('|', $params)).')');
                        break;
                    case 'card':
                        $value = str_replace(' ', '', $value);
                        $processors = [
                            'visa'      => '4[0-9]{12}(?:[0-9]{3})?',
                            'mc'        => '5[1-5][0-9]{14}',
                            'amex'      => '3[47][0-9]{13}',
                            'diners'    => '3(?:0[0-5]|[68][0-9])[0-9]{11}',
                            'discover'  => '6(?:011|5[0-9]{2})[0-9]{12}',
                            'jcb'       => '(?:2131|1800|35\\d{3})\\d{11}'
                        ];
                        $luhn = new Luhn;
                        if (count($params)) {
                            $patterns = [];
                            foreach ($params as $param) {
                                (isset($processors[$param])) ? $patterns[] = $processors[$param] : 0;
                            }
                        } else {
                            $patterns = $processors;
                        }
                        $pattern = '/^(?:'.join('|', $patterns).')$/';
                        $valid = preg_match($pattern, $value) && $luhn->validate($value);
                        break;
                }

                // If item is not validated
                // Attach a formatted message to the errors message bag
                if (!$valid) {
                    $message = [$messages[$method]];
                    $fmtmsg = call_user_func_array('sprintf', array_merge($message, $params));
                    $errors->merge([$prefix.$field => [$fmtmsg]]);
                }
            }

            // If newField exists and no errors for current field
            // Save value to result array using newField as path
            if (!empty($newField) && !$errors->has($prefix.$field)) {
                $this->setArrayPath($result, $newField, $value);
            }
        }

        // If errors exist
        // Then save to private class variable $errors
        if (!$errors->isEmpty()) {
            if (isset($this->errors) && $this->errors instanceof MessageBag) {
                $this->errors->merge($errors);
            } else {
                $this->errors = $errors;
            }
        }

        return $result;
    }

    /**
     * Marshall values of an array
     *
     * @param array     $input  Input array to marshall
     * @param array     [$rules = []] Set of rules to validate input against
     * @param string    [$messages = []] Custom messages used for valiation
     *
     * @return array    Marshalled and validated values
     */
    protected function marshall(array $input, array $rules = [], array $messages = [])
    {
        $rules = count($rules) ? $rules : $this->validationRules;
        $messages = array_merge($messages, $this->validationMessages);

        return $this->enforce($input, $rules, $messages);
    }

    /**
     * Getter method for validation rules
     *
     * @return array    Stored rules
     *
     */
    protected function getValidationRules()
    {
        return $this->validationRules;
    }

    /**
     * Setter method for validation rules
     *
     * @param array     $rules      Rules to store
     *
     * @return object   Self
     *
     */
    protected function setValidationRules(array $rules)
    {
        $this->validationRules = $rules;

        return $this;
    }

    /**
     * Getter method for validation messages
     *
     * @return array    Store messages
     *
     */
    protected function getValidationMessages()
    {
        return $this->validationMessages;
    }

    /**
     * Setter method for validation messages
     *
     * @param array     $messages       Messages to store
     *
     * @return object   Self
     *
     */
    protected function setValidationMessages(array $messages)
    {
        $this->validationMessages = $messages;

        return $this;
    }

    /**
     * Checks if errors do not exist
     *
     * @return bool
     */
    public function passes()
    {
        return !isset($this->errors) || $this->errors->isEmpty();
    }

    /**
     * Checks if errors exist
     *
     * @return bool
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Get errors if existing
     *
     */
    public function errors()
    {
        return isset($this->errors) ? $this->errors->toArray() : [];
    }

    public function forgetErrors()
    {
        $this->errors = null;
    }

    public function failWith($key, $message = null)
    {
        (!isset($this->errors)) ? $this->errors = new MessageBag : 0;

        if ($this->errors instanceof MessageBag) {
            if (is_array($key) && !isset($message)) {
                $this->errors->merge($key);
            } else {
                $error = [$key => [$message]];
                $this->errors->merge($error);
            }
        }
    }
}
