<?php

function validateRequisition($requisition)
{
	 $errors = array();

        if(empty($requisition['item_id']))
        {
            array_push($errors,'Item is required');

        }

        if(empty($requisition['item']))
        {
            array_push($errors,'Confirm Item');

        }

        if(empty($requisition['quantity']))
        {
            array_push($errors,'Quantity is required');
        }


         if(empty($requisition['reason']))
        {
            array_push($errors,'Reason is required');

        }

        return $errors;

	
}





function  validateInventory($requisition)
{
	 $errors = array();

        if(empty($requisition['item']))
        {
            array_push($errors,'Item is required');

        }

        if(empty($requisition['total']))
        {
            array_push($errors,'Quantity is required');
        }

        return $errors;

}




function  validateDecline($requisition)
{
	 $errors = array();

        if(empty($requisition['declineReason']))
        {
            array_push($errors,'Reason is required');

        }

      

      return $errors;

}


function validateCreateInventory($item)
{
     $errors = array();

        if(empty($item['item']))
        {
            array_push($errors,'Item is required');

        }

        if(empty($item['total']))
        {
            array_push($errors,'Total is required');
        }

        return $errors;

}


function validateAddInventory($item)
{
     $errors = array();

        if(empty($item['add']))
        {
            array_push($errors,'Added value is required');

        }

      

        return $errors;

}







?>