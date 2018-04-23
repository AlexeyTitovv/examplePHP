<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author Питохуй-Дядя Айро
 */
class Category {
     public static function getCategoriesList() {
        
           //запрос к бд
       
        $db = Db::getConnection();
        $categoryList = array();
        
        $result = $db->query("SELECT id, name "
                ." FROM category ORDER BY sort_order ASC  ");
        
        $i = 0;
       
        while ($row = $result->fetch(PDO::FETCH_ASSOC) ){
            $categoryList[$i]['id'] = $row['id'];
            $categoryList[$i]['name'] = $row['name'];
           
            $i++;
        }
        return $categoryList;
}}
