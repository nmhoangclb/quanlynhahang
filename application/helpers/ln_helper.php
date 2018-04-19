<?php

function label($label) {
   $ci =& get_instance();
   $lb = $ci->lang->line($label);
   if($lb) {
      return $lb;
   } else {
      return $label;
   }
}
