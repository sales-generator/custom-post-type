<?php
/*
Plugin Name: film-tweet
Plugin URI: http://v900913r.beget.tech
Description: Declares
Version: 1.0
Author: Andrey
*/


add_action( 'init', 'films' );


function films() {
	$labels = array(
    'name' => 'Фильмы',
    'singular_name' => 'Фильм',
    'add_new' => 'Добавить Фильм',
    'add_new_item' => 'Добавить новый Фильм',
    'edit_item' => 'Редактировать Фильм',
    'new_item' => 'Новый Фильм',
    'view_item' => 'Посмотреть запись о Фильме',
    'search_items' => 'Найти Фильмы',
    'not_found' =>  'Фильм не найден',
    'menu_name' => 'Фильмы'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 15,
    'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
    'supports' => array('title','editor','thumbnail', 'comments'),
	'taxonomies' => array('genres','countries','actors','year') //
  );

    register_post_type( 'films',$args);
        
       
}




// Создаем новую таксономию для фильмов
add_action( 'init', 'create_films_taxonomies', 0 );

function create_films_taxonomies(){

	/* Жанры */
  $labels = array(
    'name' => 'Жанры',
    'singular_name' => 'Жанр',
    'search_items' => 'Найти по жанру',
    'all_items' => 'Все жанры',
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' =>'Редактировать жанр',
    'update_item' => 'Обновить жанр',
    'add_new_item' => 'Добавить новый жанр',
    'new_item_name' => 'Название нового жанра',
    'menu_name' => 'Жанры',
  );

  register_taxonomy('genres', array('films'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genres' ),
  ));

  /* Страны */
  $labels = array(
    'name' => 'Страны',
    'singular_name' => 'Страна',
    'search_items' => 'Найти по стране',
    'all_items' => 'Все страны',
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' =>'Редактировать страну',
    'update_item' => 'Обновить страну',
    'add_new_item' => 'Добавить новую страну',
    'new_item_name' => 'Название новой страны',
    'menu_name' => 'Страны',
  );

  register_taxonomy('countries', array('films'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'countries' ),
  ));

  /*  Актеры */
  $labels = array(
    'name' => 'Актеры',
    'singular_name' => 'Актер',
    'search_items' => 'Найти по актеру',
    'all_items' => 'Все актеры',
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' =>'Редактировать инфо актера',
    'update_item' => 'Обновить инфо актера',
    'add_new_item' => 'Добавить нового актера',
    'new_item_name' => 'Имя актера',
    'menu_name' => 'Актеры',
  );

  register_taxonomy('actors', array('films'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'actors' ),
  ));

    /* год */
  $labels = array(
    'name' => 'Год',
    'singular_name' => 'Год',
    'search_items' => 'Найти по дате',
    'all_items' => 'За все время',
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' =>'Редактировать год',
    'update_item' => 'Обновить дату',
    'add_new_item' => 'Добавить новую дату',
    'new_item_name' => 'новая дата',
    'menu_name' => 'Год',
  );

  register_taxonomy('year', array('films'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'year' ),
  ));

}


add_action( 'admin_init', 'my_admin' );
function my_admin() {
    add_meta_box( 'movie_review_meta_box',
        'Movie Review Details',
        'display_movie_review_meta_box',
        'films', 'normal', 'high'
    );
}


function display_movie_review_meta_box( $films ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $price = ( get_post_meta( $films->ID, 'price', true ) );
    $dateRelise = ( get_post_meta( $films->ID, 'dateRelise', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Стоимость</td>
            <td><input type="text" size="80" name="price_name" value="<?php echo $price; ?>" /></td>
        </tr>

         <tr>
            <td style="width: 100%">Дата выхода в прокаты</td>
            <td><input type="text" size="80" name="dateRelise_name" value="<?php echo $dateRelise; ?>" /></td>
        </tr>
        
    </table>
    <?php
}

	
add_action( 'save_post', 'add_movie_review_fields1', 10, 10 );
function add_movie_review_fields1( $movie_review_id, $films ) {
    // Check post type for movie reviews
    if ( $films->post_type == 'films' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['price_name'] ) && $_POST['price_name'] != '' ) {
            update_post_meta( $movie_review_id, 'price', $_POST['price_name'] );
        }
        if ( isset( $_POST['dateRelise_name'] ) && $_POST['dateRelise_name'] != '' ) {
            update_post_meta( $movie_review_id, 'dateRelise', $_POST['dateRelise_name'] );
        }
    }
}






/*
add_action('add_meta_boxes', 'film_meta_box'); // Запускаем 


function film_meta_box() {
    add_meta_box(
    	'film_review_meta_box',
        'Film Meta Box',
        'film_metabox_callback',//display_movie_review_meta_box
        'films', 
        'normal',
        'high'
    );
}




function film_metabox_callback( $films ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $priceinput = ( get_post_meta( $films->ID, 'priceinput', true ) );
    $datereliseinput = ( get_post_meta( $films->ID, 'datereliseinput', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Стоимость сеанса</td>
            <td><input type="text" size="80" name="priceinput_name" value="<?php echo $priceinput; ?>" /></td>
        </tr>
        
		<tr>
            <td style="width: 100%">Дата выхода в прокат</td>
            <td><input type="text" size="80" name="datereliseinput_name" value="<?php echo $datereliseinput; ?>" /></td>
        </tr>
        

    </table>
    <?php
}




add_action( 'save_post', 'add_movie_review_fields' );

function add_movie_review_fields( $film_review_id, $films ) {
    // Check post type for movie reviews
    if ( $films->post_type == 'films' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['priceinput_name'] ) && $_POST['priceinput_name'] != '' ) {
            update_post_meta( $film_review_id, 'priceinput', $_POST['priceinput_name'] );
        }
        if ( isset( $_POST['datereliseinput_name'] ) && $_POST['datereliseinput_name'] != '' ) {
            update_post_meta( $film_review_id, 'datereliseinput', $_POST['datereliseinput_name'] );
        }
    }
}




*/

add_filter( 'template_include', 'include_template_single', 1);

function include_template_single( $template_path ) {
    if ( get_post_type() == 'films' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-films.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-films.php';
            }
        }
    }
    return $template_path;
}

add_filter( 'template_include', 'include_template_function', 1);

function include_template_function( $template_path ) {
    if ( get_post_type() == 'films' ) {
        if ( is_archive() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'archive-films.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/archive-films.php';
            }
        }
    }
    return $template_path;
}






add_action( 'include_template_function', 'ad_block' );

function ad_block() {

 ?>
  <div style="text-align: center;" >
  	<img  src="http://v900913r.beget.tech/wp-content/plugins/film-tweet/images/jc.jpg">
  </div>
<?
  
}

?>