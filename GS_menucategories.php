<?php
/*
Plugin Name: Gs_MenuCategories
Plugin URI: http://www.cerneprojetos.com.br
Description: Creates a menu structure as a widget, where all posts are placed inside the corresponding category.
Version: 0.0.1
Author: Guilherme Silva, PMP
Author URI: http://www.cerneprojetos.com.br
*/

function GS_render_Menu($args)
{


   function GS_Display_menu($args=null){
        if(is_null($args)) { $args=array('a'=>'1');}
        extract($args);
        $categorias=get_categories();
        $artigos = get_posts('numberposts=0&order=ASC&orderby=post_title');
        $options = get_option('gs_menucat');
      
        $title = ($options['title'] != "") ? $options['title'] : ""; 
 	      echo $before_widget; 
        echo $before_title . $title . $after_title;            
        foreach($categorias as $cat)
        {
  
          
          if ($cat->cat_ID!=1)
            {
               echo "<li>";
               echo $cat->name;
               echo "<ul>";
        
               foreach($artigos as $art)
               {      
                   $pcat= wp_get_post_categories($art->ID);
                   if ($pcat[0]==$cat->cat_ID)
                      {
                           echo "<li>";
                           echo "<a href=\"" . $art->guid . "\" >";
                           echo ($art->post_title) . "</a>";
                           echo "</li>";
                      }
               }
               echo "</ul></li>";
               
            }
          }
         echo $after_widget;

    } 
 function GS_Display_Control(){ 
 $options = get_option('gs_menucat');
 
 if(is_null($options)) { $options = array('title'=> "Articles") ; };
 if(!is_null($_POST['gs_menucat-title']))
            {
                $options = array('title' => $_POST['gs_menucat-title']);
                update_option('gs_menucat', $options);

            }
            echo "<p>Title:<input type=\"text\" name=\"gs_menucat-title\" value=\"" . $options['title'] . "\" id=\"gs_menucat-title\"></p>\"";
     }
 
 
  register_sidebar_widget('Mostra as categorias', 'GS_Display_menu', 1);
  register_widget_control ('Mostra as categorias', 'GS_Display_Control');
}

add_action('plugins_loaded', 'GS_render_Menu');


?>