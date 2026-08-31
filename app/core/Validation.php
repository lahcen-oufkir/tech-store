<?php

namespace App\Core;

/**
 * Lightweight validation class.
 *
 * Usage:
 *   $validator = new Validation($_POST, [
 *       'name'  => 'required|min:3|max:100',
 *       'email' => 'required|email|unique:users,email',
 *       'price' => 'required|numeric|min:0',
 *   ]);
 *   if ($validator->fails()) { ... }
 */
class Validation
{
    private $data;
    private $rules;
    private $errors = [];

    public function __construct($data, $rules)
    {
        $this->data  = $data;
        $this->rules = $rules;
        $this->validate();
    }

    private function validate()
    {
        foreach ($this->rules as $field => $ruleString) {
            $value = $this->data[$field] ?? '';

            foreach (explode('|', $ruleString) as $rule) {
                $params = [];

                if (strpos($rule, ':') !== false) {
                    [$rule, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }

                $this->applyRule($field, $value, $rule, $params);
            }
        }
    }

    private function applyRule($field, $value, $rule, $params)
    {
        switch ($rule) {
            case 'required':
                if (trim((string) $value) === '') {
                    $this->addError($field, 'is required.');
                }
                break;

            case 'email':
                if ($value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, 'must be a valid email address.');
                }
                break;

            case 'min':
                if (mb_strlen((string) $value) < (int) $params[0]) {
                    $this->addError($field, 'must be at least ' . $params[0] . ' characters.');
                }
                break;

            case 'max':
                if (mb_strlen((string) $value) > (int) $params[0]) {
                    $this->addError($field, 'must be at most ' . $params[0] . ' characters.');
                }
                break;

            case 'numeric':
                if ($value !== '' && !is_numeric($value)) {
                    $this->addError($field, 'must be a number.');
                }
                break;

            case 'min_value':
                if (is_numeric($value) && (float) $value < (float) $params[0]) {
                    $this->addError($field, 'must be at least ' . $params[0] . '.');
                }
                break;

            case 'confirmed':
                if ($value !== ($this->data[$field . '_confirmation'] ?? null)) {
                    $this->addError($field, 'confirmation does not match.');
                }
                break;

            case 'in':
                if ($value !== '' && !in_array($value, $params, true)) {
                    $this->addError($field, 'has an invalid value.');
                }
                break;

            case 'unique':
                // params: table, column, except_id
                [$table, $column] = $params;
                $exceptId = $params[2] ?? null;

                $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = ?";
                $bind = [$value];
                if ($exceptId !== null) {
                    $sql .= " AND id <> ?";
                    $bind[] = $exceptId;
                }

                $count = (int) $this->db()->value($sql, $bind);
                if ($count > 0) {
                    $this->addError($field, 'is already taken.');
                }
                break;
        }
    }

    private function db()
    {
        return Database::instance();
    }

    private function addError($field, $message)
    {
        $label = ucwords(str_replace('_', ' ', $field));
        $this->errors[$field] = $label . ' ' . $message;
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function passes()
    {
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field)
    {
        return $this->errors[$field] ?? '';
    }
}
