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
    <input type="submit" name="getList" value="更新一覧取得">
</form>
</br>

<?php

//記事一覧を取得
if(isset($_POST["getList"])) {

    $args = [
		'orderby' => 'modified',
		'order' => 'ASC',
		'numberposts' => 100
	];


    $custom_posts = get_posts($args);

?>
<form method="POST">
<?php

    foreach($custom_posts as $post){

?>

        <input type="checkbox" name="update[]" value="<?php echo $post->ID; ?>" id="check<?php echo $post->ID; ?>" checked="checked">
        <label for="check<?php echo $post->ID; ?>">
            <?php echo $post->post_title; ?>　　　最終更新日：<?php echo $post->post_modified;?>
            </br>
        </label>

<?php
        
    };

?>

</br>
<p>チェックした記事のみ更新します</p>
<input type="submit" value="更新">
</form>
    <!-- <form method="post">
    <input type="submit" name="update" value="更新">
    </form> -->

<?php
}

//チェックした記事を更新
if(isset($_POST["update"]) && is_array($_POST["update"])) {
    
    foreach($_POST["update"] as $post){

        $random = mt_rand(1,300);

        date_default_timezone_set("UTC");

        $random_new_time_gmt = date("Y-m-d H:i:s\n",strtotime("+$random seconds"));

        date_default_timezone_set("Asia/TOKYO");

        $random_new_time = date("Y-m-d H:i:s\n",strtotime("+$random seconds"));

        echo get_post($post)->post_title;
        echo "　JST".$random_new_time;
        echo "　GMT".$random_new_time_gmt."</br>";

        $my_post = [
            'ID' => $post,
            'post_modified' => $random_new_time,
            'post_modified_gmt' => $random_new_time_gmt,
        ];

        wp_update_post($my_post);
        
    }
    echo count($_POST["update"])."個の記事を更新しました";

} 

}

?>