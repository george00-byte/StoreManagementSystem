<?php


function  validateCreateLeave($leave)
{
     $errors = array();

        if(empty($leave['leaveType']))
        {
            array_push($errors,'leave value is required');

        }

      

        return $errors;

}


function  validateLeave($leave)
{
     $errors = array();
        
        if(empty($leave['leaveType']))
        {
        
            array_push($errors,'Leave Type is required');

        }

        if(empty($leave['starting_at']))
        {
            array_push($errors,'Starting Date is required');

        }

          if(empty($leave['ending_at']))
        {
            array_push($errors,'Ending Date is required');

        }

        
          if(empty($leave['reason']))
        {
            array_push($errors,'Reason is required');

        }

      

        return $errors;

}




?>
