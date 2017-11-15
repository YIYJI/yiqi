<?php
/**
 * User: pandaxnm
 * Date: 2017/9/7
 * Time: 16:35
 */

class LinkController{
    public function index(){
        $con_link = new Model('friendlink');
        $links = $con_link->select()[0];
    }
}