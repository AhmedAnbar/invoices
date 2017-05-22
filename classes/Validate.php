<?php

class Validate {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
          $name = $items[$item]['name'];
          $value = $source[$item];
            foreach($rules as $rule => $rule_value){
                // If rule is require and user no't enter data add error
                if($rule == 'require' && empty($value))
                    {
                        $this->addErrors("{$name} is requierd");
                    } elseif (!empty($value)) 
                        {
                          switch ($rule) 
                            {
                                case 'min':
                                  if (strlen($value) < $rule_value) 
                                    {
                                        $this->addErrors("{$name} must be minimum of {$rule_value} character");
                                    }
                                  break;
                                case 'max':
                                  if (strlen($value) > $rule_value) 
                                    {
                                        $this->addErrors("{$name} must be maximum of {$rule_value} character");
                                    }
                                  break;
                                case 'matche':
                                  if ($value != $source[$rule_value]) 
                                    {
                                        $this->addErrors("{$name} not matches");
                                    }
                                  break;
                                case 'unique':
                                  $check = $this->_db->query("SELECT * FROM {$rule_value} WHERE {$item} = ?", array($value));
                                  if ($check->count()) 
                                    {
                                        $this->addErrors("{$name} alrady exists.");
                                    }
                                  break;
                                case 'type':
                                    if ($rule_value == 'email') 
                                        {
                                            if (!filter_input(INPUT_POST, $item, FILTER_VALIDATE_EMAIL)) 
                                                {
                                                    $this->addErrors("{$name} must be a valid email");
                                                }
                                        } 
                                    elseif ($rule_value == 'number') 
                                        {
                                            if (!filter_input(INPUT_POST, $item, FILTER_VALIDATE_FLOAT)) 
                                                {
                                                    $this->addErrors("{$name} must be a valid number");
                                                }
                                        }
                                    break;
                            }
                        }
            }
        }
        // If no errors are sotred in errors array make passed true
        if(empty($this->_errors)){
            $this->_passed = true;
        }
        // Return current object
        return $this;
    }
    // Add Error To Errors Array
    private function addErrors($error){
        $this->_errors[] = $error;
    }
    // Check If Validation Passed Or Not
    public function passed() {
        return $this->_passed;
    }
    // Return Array Of Errors
    public function errors(){
        return $this->_errors;
    }
}

?>
