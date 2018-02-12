<?php
  namespace Core;


  class Validator {

    private $errors = [];
    private $defaultRules = array(
      'email' => '/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
      'required' => '/[\s\S]/'
    );

    public function validate(array $inputs, array $rules) {

      $checked = true;

      foreach($rules as $field => $rule) {
        if ($this->checkForRegexp($rule)) {
          $check = $this->checkRegexp($inputs[$field], $rule);
          $checked = $checked && $check;
          if (!$check) {
            $this->errors[] = "Invalid $field";
          }
          continue;
        }
        $ruleAr = explode('|', $rule);
        $defaultRules = $this->defaultRules;
        foreach ($ruleAr as $key => $value) {
          if (array_key_exists($value, $defaultRules)) {
            $check = $this->checkRegexp($inputs[$field], $defaultRules[$value]);
            $checked = $checked && $check;
            if (!$check) {
              $this->errors[] = "Invalid $field";
            }
          }
        }
      }
      return $checked;
    }

    public function is_success() {
      return count($this->errors) > 0 ? false : true;
    }

    public function getErrors() {
      return $this->errors;
    }

    private function checkRegexp($field, $rule) {
      if ( !preg_match( $rule, $field ) ) {
        return false;
      }
      return true;
    }
    private function checkForRegexp($rule) {
      $regex =  '/\/[\s\S]{1,}\//';
      if ( !preg_match( $regex, $rule ) ) {
        return false;
      }
      return true;
    }

  }
