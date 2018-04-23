<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author Питохуй-Дядя Айро
 */
class Db {
    public static function getConnection(){

        
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);
        
        $db1 = "mysql:host={$params['host']}; dbname={$params['dbname']}";
        $db2 = $params['user'];
        $db3 = $params['password'];
        $db= new PDO ($db1 ,$db2, $db3);
        $db -> exec("set names utf8");
        
       return $db ;
}}
