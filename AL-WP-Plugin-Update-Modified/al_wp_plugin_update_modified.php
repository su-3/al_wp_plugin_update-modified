<?php 
/*
Plugin Name: AL WP Plugin Update Modified
*/
 add_action( 'admin_menu', 'my_admin_menu');

 function my_admin_menu() {

    add_menu_page(
        __('AL WP Plugin Update Modified', 'my-custom-admin'),
        __('AL WP Plugin Update Modified', 'my-custom-admin'),
        'administrator',
        'my-custom-admin',
        'my_custom_admin'
   
    );
 }

 function my_custom_admin()  {
?>
<form method="post">
    <input type="submit" name="update" value="更新">
</form>

<?php


if(isset($_POST["update"])) {

    $args = [
		'orderby' => 'modified',
		'order' => 'ASC',
		'numberposts' => 100
	];


    $stack = array();
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post){
        
        $new_time = current_time('mysql');
        $new_time_gmt = current_time('mysql',1);
        $success_message =null;
        // $post->post_date;
        // 公開日
        
        // $post->post_modified;
        // 更新日

        $my_post = [
            'ID' => $post->ID,
            'post_modified' => $new_time,
            'post_modified_gmt' => $new_time_gmt,

        ];

        $ret = wp_update_post($my_post);
        if ($ret !== $post->ID){
            echo "★NG:" . $post->ID;
        }
        array_push($stack,$post->post_title);

    };
    ?>
    <p>
        <?php echo '以下'.count($stack).'個の記事を更新しました<br/>'; ?>
    </p>
<?php
    foreach($stack as $value) {
        echo 'OK:'.$value.'<br />';
    }    
}

}
?>
