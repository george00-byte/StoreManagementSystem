<?php

function validateUser($user)
{
	 $errors = array();

        if(empty($user['username']))
        {
            array_push($errors,'username is required');

        }

        if(empty($user['email']))
        {
            array_push($errors,'Email is required');
        }

        if(empty($user['password']))
        {
            array_push($errors,'Password is required');

        }

         if(empty($user['department']))
        {
            array_push($errors,'Department is required');

        }



        if($user['password'] !== $_POST['passwordConf'])
        {
            array_push($errors,'Passwords do not match');
        }


        $existingUser = selectOne('users',['email'=>$user['email']]);

          if(isset($existingUser))
        {
            if(isset($_POST['create-user']) && $existingUser['id'] != $user['id'])
            {
                array_push($errors,'Email already exists');
            }

            if(isset($_POST['create-admin']))
            {
                array_push($errors,'Email already exists');
            }

             if(isset($_POST['register-btn']))
            {
                array_push($errors,'Email already exists');
            }
            
        }
	     return $errors;
	
}


function validateLogin($user)
{
	 $errors = array();

        if(empty($user['email']))
        {
            array_push($errors,'Email is required');

        }


        if(empty($user['password']))
        {
            array_push($errors,'Password is required');

        }

        if(!$user)
        {
        
            array_push($errors,'User does not exist');

        }

	    return $errors;
	
}








?>