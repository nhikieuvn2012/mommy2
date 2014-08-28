<?php
    include_once("wp-load.php");
    $pid=intval($_GET['pid']);
    $post=get_post($pid);
    
    $p_name=$post->post_title;
    $p_txt=$post->post_content;
    
    $price=get_post_meta($pid,'price',true);
    $size=get_post_meta($pid,'size',true);
    $color=get_post_meta($pid,'color',true);
    $imgId=get_post_thumbnail_id($pid);
    
    $wp_query = new WP_Query();
                    
    $properties = array('post_type' =>  'shopping_cart');
    $query = $wp_query->query($properties);
    
    foreach ($query as $perres){
        
        $arr_product_id[].=get_post_meta($perres->ID,'productid',true);
        $arr_id[].=$perres->ID;
    }
    
    
    if(in_array($pid,$arr_product_id)){
        
        $wp_query = new WP_Query();
        
        $properties = array(
                'post_type' =>  'shopping_cart',
                'meta_query' => array(),
         );
        
        $properties['meta_query'][] = array(
        'key' => 'productid',
        'value' => $pid,
        'compare' => 'LIKE'
        );
        
        foreach ($query as $perres){
            $q=get_post_meta($perres->ID,'quangtity',true);
            $count_p=intval($q)+1;
            update_post_meta($perres->ID,'quangtity',$count_p,true);
        }
        
    }else{
        $my_post = array(
          'post_title'    => $p_name,
          'post_content'  => $p_txt,
          'post_status'   => 'publish',
          'post_type'     => 'shopping_cart',
          'post_author'   => 1,
        );
        
        // Insert the post into the database
        $new_post=wp_insert_post( $my_post );
        
        add_post_meta($new_post,'price',$price,true);
        add_post_meta($new_post,'size',$size,true);
        add_post_meta($new_post,'quangtity','1',true);
        add_post_meta($new_post,'productid',$pid,true);
        add_post_meta($new_post,'color',$color,true);
        set_post_thumbnail($new_post,$imgId);
    }
    
?>