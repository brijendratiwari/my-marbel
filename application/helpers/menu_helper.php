<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('BASEPATH') OR exit('No direct script access allowed');
function buildMenu($parent, $menu,$child = 0) {
    
        $childClass = '';
        if($child == 1){
            
            $childClass= "class='child-li'";
        }
    
        $html = "";
        $nav='';
       if($menu['parent_menus'][$parent][0]==1){
          $nav="id='nav'";
       }
        if (isset($menu['parent_menus'][$parent])) {

            $html .= "<ul ".$nav." >";

                foreach ($menu['parent_menus'][$parent] as $menu_id) {
                        if (!isset($menu['parent_menus'][$menu_id])) {
                                $html .= "<li ".$childClass." class='parent-li'  id='".$menu['menus'][$menu_id]['id']."'>" . $menu['menus'][$menu_id]['user_role_type'] . "</li>";
                        }
                        if (isset($menu['parent_menus'][$menu_id])) {
                                $html .= "<li   id='".$menu['menus'][$menu_id]['id']."'>" . $menu['menus'][$menu_id]['user_role_type'];
                                $html .= buildMenu($menu_id, $menu,1);
                                $html .= "</li>";
                        }

                }
                $html .= "</ul>";
        }
        return $html;
}
