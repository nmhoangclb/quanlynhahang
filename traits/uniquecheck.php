<?php
trait uniquecheck {
    //@JA - This function can do single and multi-unique checks.
    //@JA - This is programmed to be replaced at a later date when validates_uniqueness_of is fixed (http://www.phpactiverecord.org/projects/main/wiki/Validations#validates_uniqueness_of)
    //@JA - EXAMPLES
    //SINGLE    -- array('name','message' => 'Can't do this')
    //MULTIPLE  -- array( array('name1','name2'), 'message' => 'can't do this and that together')
    //@JA - To be clear multiple does not mean 2 different uniques but a unique on 2 columns.  Just use this function twice for 2 separate unique checks.
    //@JA -  Refer to (https://github.com/jpfuentes2/php-activerecord/issues/336)
    public function uniquecheck($rules = array()) {
        //@JA - If its an array use the MULTIPLE method

        $dirty = $this->dirty_attributes();//@JA - Get list of attributes that have been modified since loading the model

        if(is_array($rules[0])){
            //@JA - Generate first part of condition string
            $uniques = $rules[0];
            foreach($uniques as $unique){
                $conditionstring .= "$unique = ? AND ";
            }
            $conditionstring = substr($conditionstring, 0, -5);

            $dirtyfound = false;

            //@JA - Then generate the array we will use for the conditions
            $conditionarray['conditions'][] = $conditionstring;
            foreach($uniques as $unique){
                $conditionarray['conditions'][] = $this->read_attribute($unique);
                if(array_key_exists($unique, $dirty)){
                    $dirtyfound = true;
                }
            }

            if ($dirtyfound == true) { //@JA - If one of the parts that makes the record unique is dirty then...
                try {
                    //@JA - Whatever the primary key currently is return the object for that.  This will be the object reference for what is not modified
                    $currently = Self::find($this->id);
                }
                catch (Exception $e) {
                    $currently = false;
                }

                foreach($uniques as $unique){
                    if ((
                        (is_object($currently) && $currently->$unique != $this->$unique)
                        || !is_object($currently)
                    ) && static::exists($conditionarray))
                        $this->errors->add($unique, $rules['message']);
                }
            }
        }else{ //@JA - Otherwise use the SINGLE method

            $unique = $rules[0];
            if (array_key_exists($unique, $dirty)) { //@JA - If the value we are checking to be unique has been modified...
                try {
                    //@JA - Whatever the primary key currently is return the object for that.  This will be the object reference for what is not modified
                    $currently = Self::find($this->id);
                }
                catch (Exception $e) {
                    $currently = false;
                }

                //@JA - The dirty attributes array simply contains fields that have been set by our code.
                //@JA - Ergo if we have re-applied the same value to our model, it will be classed as dirty even though it has not changed
                //@JA - If $currently was returned as an object type AND its original value does not equal the current dirty value of the property on the model
                //@JA - OR If the object returned was not an object (meaning it does not currently exists in the database)...
                //@JA - OR it could mean that the table is just empty for the first time... Thus
                //@JA - AND if the dirty value of the unique was found to exist then a unique was found.
                if ((
                    (is_object($currently) && $currently->$unique != $this->$unique)
                    || !is_object($currently)
                ) && static::exists(array($unique => $this->$unique)))
                    $this->errors->add($unique, $rules['message']);
            }
        }
    }
}
?>
