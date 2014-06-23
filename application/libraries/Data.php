<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class data {
    public function toUS($data) {
        if(empty($data)) return "0000-00-00";
        $data = explode("/", $data);
        return $data[2] . "-" . $data[1] . "-" . $data[0];
    }
    
    public function toBR($data) {
        if(empty($data)) return "00/00/0000";
        $data = explode("-", $data);
        return $data[2] . "/" . $data[1] . "/" . $data[0];
    }
}