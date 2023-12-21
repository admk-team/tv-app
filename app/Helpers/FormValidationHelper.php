<?php

namespace App\Helpers;

class FormValidationHelper
{
    public static function validateForm($fieldsToBeValidate)
    {
        $password = '';
        $cnt = 0;
        foreach ($fieldsToBeValidate as $key => $val)
        {
            $fieldKey = $key;
            $fieldValue = @trim($_REQUEST[$key]);

            if (!$fieldValue) $fieldValue = @trim($_FILES[$key]['name']);
            $fieldType = $val['type'];

            if ($fieldType == 'text' || $fieldType == 'textarea')
            {
                $msg = 'Please enter ';
                $fieldType = 'default';
            }
            else if ($fieldType == 'optionTxt') 
            {
                $msg = 'Please enter ';
                $fieldType = 'optionTxt';
            }		
            else if ($fieldType == 'checkBox')
            {
                $msg = 'Please check ';
                $fieldType = 'default';

            } 
            else if ($fieldType == 'dropDown')
            {
                $msg = 'Please select ';
                $fieldType = 'default';
            }		

            switch ($fieldType)
            {
                // default case handle text, checkbox and dropdown
                case 'default':
                    if (empty($fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = $msg . $val['msg'];
                    } 
                    else if (!empty($val['min']) && strlen($fieldValue) < $val['min']['length']) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter minimum ' . $val['min']['msg'];
                    }
                    else if (!empty($val['max']) && strlen($fieldValue) > $val['max']['length'])
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter maximum ' . $val['max']['msg'];
                    }
                    else if (!empty($val['regex']) && !preg_match('/' . $val['regex']['pattern'] . '/', $fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = $val['regex']['msg'];
                    }
                    break;

                case 'optionTxt':
                    if (!empty($val['min']) && strlen($fieldValue) < $val['min']['length'])
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter minimum ' . $val['min']['msg'];
                    } 
                    else if (!empty($val['max']) && strlen($fieldValue) > $val['max']['length'])
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter maximum ' . $val['max']['msg'];
                    }
                    else if ($fieldValue != '' && !empty($val['regex']) && !preg_match('/' . $val['regex']['pattern'] . '/', $fieldValue))
                    {
                        $_SESSION['formMessage'][$fieldKey] = $val['regex']['msg'];
                    }
                    break;
                
                case 'optionEmail':
                    if (!empty($fieldValue) && !filter_var($fieldValue, FILTER_VALIDATE_EMAIL))
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter valid ' . $val['msg'];
                    }
                    break;

                case 'imageUpload':
                    $oldFileName = @trim($_REQUEST['oldFileName']);
                    if (empty($fieldValue) && !$oldFileName)
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter ' . $val['msg'];				
                    } 
                    else if ($fieldValue != '' && !preg_match('/^.*\.(jpg|jpeg|gif|JPG|png|PNG)$/', ".".pathinfo($fieldValue, PATHINFO_EXTENSION)))
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please uplaod valid image format' ;
                    }
                    break;

                case 'optionImageUpload':
                    $oldFileName = @trim($_REQUEST['oldFileName']);
                    if ($fieldValue == '') $fieldValue = $oldFileName;
                    if ($fieldValue != '' && !preg_match('/^.*\.(jpg|jpeg|gif|JPG|png|PNG)$/', ".".pathinfo($fieldValue, PATHINFO_EXTENSION)))
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please uplaod valid image format' ;
                    }
                    break;

                case 'email':
                    if (empty($fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter ' . $val['msg'];				
                    }
                    else if (!filter_var($fieldValue, FILTER_VALIDATE_EMAIL))
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter valid ' . $val['msg'];
                    }
                    break;

                case 'password': 
                    if (empty($fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter ' . $val['msg'];	

                    }
                    else if (!empty($val['min']) && strlen($fieldValue) < $val['min']['length'])
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter minimum ' . $val['min']['msg'];

                    } 
                    else if (!empty($val['max']) && strlen($fieldValue) > $val['max']['length']) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter maximum ' . $val['max']['msg'];
                    } 
                    else if (!empty($val['regex']) && !preg_match('/' . $val['regex']['pattern'] . '/', $fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = $val['regex']['msg'];
                    }
                    // To use in confirm password
                    $password = $fieldValue;
                    break;
                
                case 'cpassword':
                    if (empty($fieldValue))
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter ' . $val['msg'];	

                    }
                    else if (!empty($val['min']) && strlen($fieldValue) < $val['min']['length']) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter minimum ' . $val['min']['msg'];

                    }
                    else if (!empty($val['max']) && strlen($fieldValue) > $val['max']['length'])
                    {
                        $_SESSION['formMessage'][$fieldKey] = 'Please enter maximum ' . $val['max']['msg'];

                    }
                    else if (!empty($val['regex']) && !preg_match('/' . $val['regex']['pattern'] . '/', $fieldValue)) 
                    {
                        $_SESSION['formMessage'][$fieldKey] = $val['regex']['msg'];

                    }
                    else if ($fieldValue != $password)
                    {					
                        $_SESSION['formMessage'][$fieldKey] = 'Confirm password does not match';
                    } 
                    break;			
            }
        }

        if (isset($_SESSION['formMessage']) && count($_SESSION['formMessage']) > 0) return true;
        else return false;
    }

    public static function showErrorMessage($field)
    {
        if (session('formMessage') && session('formMessage')[$field])
        {
            echo session('formMessage')[$field];
            unset(session('formMessage')[$field]);
        }
    }

    public static function unsetSessionVariables()
    {
        unset($_SESSION['formMessage']);
        unset($_SESSION['formValidation']);
    }
}