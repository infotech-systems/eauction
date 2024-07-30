<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('dateBritish'))
{
    function dateBritish($givenDate=null)
    {
        $date=substr($givenDate,8,2).'/'.substr($givenDate,5,2).'/'.substr($givenDate,0,4);
        return $date;
    }
}