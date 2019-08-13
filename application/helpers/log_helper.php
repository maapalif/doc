<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function helper_log($tipe = "", $str = "", $user = "", $dept = ""){
    $CI =& get_instance();
 
    if (strtolower($tipe) == "login"){
        $log_tipe   = 0;
    }
    elseif(strtolower($tipe) == "logout")
    {
        $log_tipe   = 1;
    }
    elseif(strtolower($tipe) == "add"){
        $log_tipe   = 2;
    }
    elseif(strtolower($tipe) == "edit"){
        $log_tipe  = 3;
    }
    else{
        $log_tipe  = 4;
    }
 
    // paramter
    $param['l_User']      = $user;
    $param['l_Tipe']      = $log_tipe;
    $param['l_Desc']      = $str;
    $param['l_Dept']      = $dept;
 
    //load model log
    $CI->load->model('Tree_model');
 
    //save to database
    $CI->Tree_model->save_log($param);
 
}

?>