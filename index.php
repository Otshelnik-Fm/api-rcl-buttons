<?php

/*
Plugin Name:    api-rcl-buttons
Description:    api кнопок
Version:        0.6
Author:         Otshelnik-Fm (Wladimir Druzhaev)
Author URI:     https://otshelnik-fm.ru/
*/

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/

// разместите кнопки на странице шорткодом [apib_get_button]


// svg compressor https://jakearchibald.github.io/svgomg/ 304kb in / 255kb out

// style & svg
function apib_load_resource() {
    wp_enqueue_style(
        'apib_style',
        plugins_url('api.css', __FILE__)
    );

    wp_enqueue_script(
        'apib_script',
        plugins_url('assets/svg/icons.js', __FILE__)
    );
}
//add_action('wp_enqueue_scripts','apib_load_resource',10);




// шорткод
function apib_short(){
    return do_action('apib_button');
}
add_shortcode('apib_get_button', 'apib_short');




// внутри кнопок svg
function svg_get_button($bttn_text=false,$url,$args=false){
/**
$args['id']
$args['class']  // свой доп класс
$args['type']   // rcl-bttn__type-primary | rcl-bttn__type-clear - тип кнопки - залита цветом или простая
$args['attr']
$args['title']  // тайтл

$args['icon']   // uspic-heart_broken
$args['avatar']    // <img alt='' src='...
$args['counter']  // 12
$args['icon']  // иконка справа
*/
if(is_array($args)){
    $args = array_filter($args); // unset $args[key] = '';
} else {
    $args = array();
}


$dop_class = ''; // доп классы для возможности стилизации кнопки в зависимости от ее состава
if( isset($bttn_text) && array_key_exists('ricon', $args) && empty($args['counter']) ){ // кнопка из текста и только иконки справа
    //if( !empty($args['icon']) ) {
        $dop_class = 'rcl-bttn__mod-text-rico';
    //}
}
else if ( isset($bttn_text) && array_key_exists('ricon', $args) && array_key_exists('count', $args) && empty($args['avatar']) ){
    //if( !empty($args['icon']) && !empty($args['counter']) ) { // текст иконка справа и счетчик
        $dop_class = 'rcl-bttn__mod-text-rico-count';
    //}
}
else if ( empty($bttn_text) && array_key_exists('icon', $args) && empty($args['counter']) && empty($args['icon']) && empty($args['avatar']) ){
    // только иконка
    $dop_class = 'rcl-bttn__mod-only-icon';
}

    $type = (isset($args['type']))? $args['type']: 'rcl-bttn__type-primary';
    $class = (isset($args['class']))? $args['class']: '';

    $button = '<a href="'.$url.'"';
        if(isset($args['id'])&&$args['id']) $button .= ' id="'.$args['id'].'"';

        $button .= ' class="rcl-bttn '.$type.' '.$class.' '.$dop_class.'"';

        if(isset($args['attr'])&&$args['attr']) $button .= ' '.$args['attr'].'';

        if(isset($args['title'])&&$args['title']) $button .= ' title="'.$args['title'].'"';
    $button .= '>';
        if(isset($args['icon'])&&$args['icon']) $button .= '<i class="rcl-bttn__ico rcl-bttn__ico-left"><svg class="uspic-icon '.$args['icon'].'"><use xlink:href="#'.$args['icon'].'"></use></svg></i>';

        if(isset($args['avatar'])&&$args['avatar']) $button .= '<i class="rcl-bttn__ava">'.$args['avatar'].'</i>';

        if($bttn_text) $button .= '<span class="rcl-bttn__text">'.$bttn_text.'</span>';

        if(isset($args['icon'])&&$args['icon']) $button .= '<i class="rcl-bttn__ico rcl-bttn__ico-right"><svg class="uspic-icon '.$args['icon'].'"><use xlink:href="#'.$args['icon'].'"></use></svg></i>';

        if(isset($args['counter'])&&$args['counter']) $button .= '<span class="rcl-bttn__count">'.$args['counter'].'</span>';


    $button .= '</a>';

    return $button;
}




// примеры:


// Пример всех кнопок
function all_buttons1(){
    echo '<h5>Тип кнопки "rcl-bttn__type-primary" - без модификаторов</h5>';

    echo '"rcl-bttn__type-primary" - это кнопка с фоновым цветом. Реколл цвет, что задается в админке<br>';
    echo 'Здесь собраны все существующие виды кнопок. Размер дефолтный. Никаких модификаторов:<br/>';

echo '<hr style="margin: 12px 0;">';

    echo '<strong>иконка:</strong><br/>';
    $args['icon'] = 'fa-user-o';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'fa-gift';
    $args['counter'] = '31';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['counter'] = '2';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['counter'] = '156';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';
    $args['icon'] = 'fa-id-badge';
    $args['title'] = 'Перейти в кабинет';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['title'] = '';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';
    $args['counter'] = '';
    $args['icon'] = '';

    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';

    $args['counter'] = '31';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '421';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '7';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';

    $args['label'] = 'В кабинет';
    $args['icon'] = 'fa-id-badge';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon_align'] = 'right';

    $args['label'] = 'В кабинет';
    $args['icon'] = 'fa-sign-out';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    $args['icon'] = 'fa-upload';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['counter'] = '2398';
    $args['icon'] = 'fa-star-o';
    $args['label'] = 'Рейтинг';
    echo rcl_get_button($args);

    $args['counter'] = '74';
    $args['icon'] = 'fa-comment-o';
    $args['label'] = 'Комментариев';
    echo rcl_get_button($args);

    $args['counter'] = '21';
    $args['icon'] = 'fa-handshake-o';
    $args['label'] = 'Друзей';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['counter'] = '';
    $args['icon'] = '';

    $args['avatar'] = get_avatar(1, 26);
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['avatar'] = get_avatar(3, 26);
    $args['counter'] = '7';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['label'] = '';

    $args['avatar'] = get_avatar(2, 26);
    $args['counter'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo rcl_get_button($args);

    $args['avatar'] = get_avatar(108, 26);
    $args['counter'] = '';
    $args['title'] = '';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

}
add_action('apib_button','all_buttons1');




// дизайн кнопок - простой
function all_buttons_simple(){
echo '<hr style="margin: 12px 0;">';
echo '<div style="margin: 12px 0;"></div>';
echo '<hr style="margin: 12px 0;">';
    echo '<h5>Тип кнопки "simple" (получает класс: rcl-bttn__type-simple) - без модификаторов</h5>';

    echo '"simple" - это простая кнопка с обводкой. <br>';
    echo 'Данная кнопка подойдет на большинство дизайнов сайта - как нейтральная. Постраничная навигация может быть сделана этими кнопками<br>';
    echo 'Здесь собраны все существующие виды кнопок. Размер дефолтный. Никаких модификаторов:<br/>';

echo '<hr style="margin: 12px 0;">';

    echo '<strong>иконка:</strong><br/>';
    $args['type'] = 'simple';
    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'fa-gift';
    $args['counter'] = '31';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['counter'] = '2';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['counter'] = '156';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';

    $args['icon'] = 'fa-id-badge';
    $args['title'] = 'Перейти в кабинет';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['title'] = '';

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';

    $args['counter'] = '';
    $args['icon'] = '';
    $args['type'] = 'simple';

    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>Пагинация (тоже текст):</strong><br/>';

    $args['label'] = '1';
    echo rcl_get_button($args);

    $args['label'] = '2';
    echo rcl_get_button($args);

    $args['label'] = '3';
    echo rcl_get_button($args);

    $args['label'] = '...';
    echo rcl_get_button($args);

    $args['label'] = '22';
    echo rcl_get_button($args);

    $args['label'] = '23';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';
    $args['counter'] = '31';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '421';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '7';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon_align'] = 'right';

    $args['icon'] = 'fa-sign-out';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-upload';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['counter'] = '2398';
    $args['icon'] = 'fa-star-o';
    $args['label'] = 'Рейтинг';
    echo rcl_get_button($args);

    $args['counter'] = '74';
    $args['icon'] = 'fa-comment-o';
    $args['label'] = 'Комментариев';
    echo rcl_get_button($args);

    $args['counter'] = '21';
    $args['icon'] = 'fa-handshake-o';
    $args['label'] = 'Друзей';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['icon_align'] = '';
    $args['counter'] = '';
    $args['icon'] = '';

    $args['label'] = 'В кабинет';
    $args['avatar'] = get_avatar(1, 26);
    echo rcl_get_button($args);

    $args['label'] = 'В кабинет';
    $args['avatar'] = get_avatar(3, 26);
    $args['counter'] = '7';
    echo rcl_get_button($args);

    $args['label'] = '';
    $args['avatar'] = get_avatar(2, 26);
    $args['counter'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo rcl_get_button($args);

    $args['avatar'] = get_avatar(108, 26);
    $args['counter'] = '';
    $args['title'] = '';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

}
add_action('apib_button','all_buttons_simple');




// кнопки без дизайна
function all_buttons_clear(){
echo '<hr style="margin: 12px 0;">';
echo '<div style="margin: 12px 0;"></div>';
echo '<hr style="margin: 12px 0;">';
    echo '<h5>Тип кнопки "clear" (получает класс: rcl-bttn__type-clear) - без модификаторов</h5>';

    echo '"clear" - это простая кнопка без фонового цвета. Как ссылка.<br>';
    echo 'Данная кнопка будет полезна чтобы задавать свои стили или для использования в вертикальных группах<br>';
    echo 'Здесь собраны все существующие виды кнопок. Размер дефолтный. Никаких модификаторов:<br/>';

echo '<hr style="margin: 12px 0;">';

    echo '<strong>иконка:</strong><br/>';
    $args['type'] = 'clear';
    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'fa-gift';
    $args['counter'] = '31';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['counter'] = '2';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['counter'] = '156';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';
    $args['icon'] = 'fa-id-badge';
    $args['title'] = 'Перейти в кабинет';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['title'] = '';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';

    $args['counter'] = '';
    $args['icon'] = '';
    $args['type'] = 'clear';

    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';
    $args['counter'] = '31';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '421';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '7';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['counter'] = '';

    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon_align'] = 'right';

    $args['label'] = 'В кабинет';
    $args['icon'] = 'fa-sign-out';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать авто';
    $args['icon'] = 'fa-upload';
    echo rcl_get_button($args);

    $args['label'] = 'Подобрать билет';
    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['counter'] = '2398';
    $args['icon'] = 'fa-star-o';
    $args['label'] = 'Рейтинг';
    echo rcl_get_button($args);

    $args['counter'] = '74';
    $args['icon'] = 'fa-comment-o';
    $args['label'] = 'Комментариев';
    echo rcl_get_button($args);

    $args['counter'] = '21';
    $args['icon'] = 'fa-handshake-o';
    $args['label'] = 'Друзей';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['icon_align'] = '';
    $args['counter'] = '';
    $args['icon'] = '';

    $args['label'] = 'В кабинет';
    $args['avatar'] = get_avatar(1, 26);
    echo rcl_get_button($args);

    $args['label'] = 'В кабинет';
    $args['avatar'] = get_avatar(3, 26);
    $args['counter'] = '7';
    echo rcl_get_button($args);

    $args['label'] = '';
    $args['avatar'] = get_avatar(2, 26);
    $args['counter'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo rcl_get_button($args);

    $args['avatar'] = get_avatar(108, 26);
    $args['counter'] = '';
    $args['title'] = '';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';

}
add_action('apib_button','all_buttons_clear');



// размеры кнопок
function vdss_button_sizes(){
echo '<br/><br/>';

echo '<h2>Использование модификаторов:</h2>';
echo '<br/>';

    echo '<h5>Размеры - size:</h5>';
    echo 'Если нет класса - то это равносильно "standart".<br/>';
    echo '<strong>без доп класса | medium | large | big:</strong><br/>';

    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);


    $args['size'] = 'medium';
    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);


    $args['size'] = 'large';
    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);


    $args['size'] = 'big';
    $args['icon'] = 'fa-gift';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

    $args['size'] = '';
    $args['icon'] = 'fa-gift';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'medium';
    $args['icon'] = 'fa-gift';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'large';
    $args['icon'] = 'fa-gift';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'big';
    $args['icon'] = 'fa-gift';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';

    $args['type'] = 'simple';
    $args['size'] = '';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'medium';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'large';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    $args['size'] = 'big';
    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';


echo '<hr style="margin: 12px 0;">';

    $args['type'] = '';
    $args['counter'] = '';
    $args['icon'] = 'fa-gift';

    $args['size'] = 'standart';
    echo rcl_get_button($args);

  echo '<br/><br/>';

    $args['size'] = 'medium';
    echo rcl_get_button($args);

  echo '<br/><br/>';

    $args['size'] = 'large';
    echo rcl_get_button($args);

  echo '<br/><br/>';

    $args['size'] = 'big';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_sizes');



// иконка - текст полная ширина
function vdss_button_fullwidth(){
  echo '<br/>';
    echo '<h5>Полная ширина:</h5>';
    echo 'Указание атрибута <strong>fullwidth</strong><br>';
    echo '$args["fullwidth"] = 1;<br>';

    $args['icon'] = 'fa-user-o';
    $args['fullwidth'] = 1;
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_fullwidth');



// маска на иконке
function vdss_button_mask(){
  echo '<br/>';
    echo '<h5>Маска на иконке:</h5>';

    echo 'Указание атрибута <strong>icon_mask</strong> и size medium<br>';
    echo '$args["icon_mask"] = 1;<br>';


    $args['size'] = 'medium';
    $args['icon_mask'] = 1;

    $args['icon'] = 'fa-gift';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    echo 'текст - иконка справа';
echo '<br/>';
    // текст - иконка справа
    $args['icon_align'] = 'right';
    $args['size'] = 'medium';
    $args['icon_mask'] = 1;

    $args['icon'] = 'fa-upload';
    $args['title'] = 'Скачать файл';
    $args['label'] = 'Скачать';
    echo rcl_get_button($args);

    $args['icon'] = 'fa-sign-out';
    $args['title'] = 'Нажмите чтобы продолжить';
    $args['label'] = 'Перейти';
    echo rcl_get_button($args);

echo '<br/><br/>';

    echo 'иконка - текст - счётчики:<br/>';
    $args['title'] = '';
    $args['icon_align'] = '';
    $args['size'] = 'medium';
    $args['icon_mask'] = 1;

    $args['counter'] = '12';
    $args['icon'] = 'fa-id-badge';
    $args['label'] = 'В кабинет';
    echo rcl_get_button($args);

    $args['counter'] = '99';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['counter'] = '652';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет';
    echo rcl_get_button($args);

echo '<br/><br/>';

    echo 'текст, иконка (справа) - счётчики (иконка-счётчик группируется):<br/>';
    $args['size'] = 'medium';
    $args['icon_mask'] = 1;
    $args['icon_align'] = 'right';

    $args['counter'] = '36';
    $args['icon'] = 'fa-upload';
    $args['label'] = 'Скачать';
    echo rcl_get_button($args);

    $args['counter'] = '249';
    $args['icon'] = 'fa-sign-out';
    $args['label'] = 'Перейти';
    echo rcl_get_button($args);

echo '<br/><br/>';

echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_mask');




// использование обёрток
function vdss_button_wrappers(){
  echo '<br/>';
    echo '<h2>Использование обёрток (wrappers):</h2>';

    echo 'Если не оборачивать в дополнительный div - то все кнопки будут горизонтально выравниваться от левого края.';
    echo '<br> - но в таком случае они будут инлайновые. Если вам все же надо чтобы кнопки шли с новой строки - оборачивайте в div <strong>rcl-wrap</strong> - тогда кнопки будут идти в начале строки и позиционироваться слева (по умолчанию).';

  echo '<div style="margin: 12px 0;"></div>';

    echo '<br><strong>Пример:</strong><br>';

     echo 'какой-то текст и мы решили вставить просто кнопку ';
        $args['icon'] = 'fa-id-badge';
        $args['label'] = 'В кабинет';
        echo rcl_get_button($args);

  echo '<div style="margin: 12px 0;"></div>';

    echo '<br><strong>Пример c wrapper:</strong><br>';

    echo 'какой-то текст и мы решили вставить просто кнопку ';
    echo '<div class="rcl-wrap">';
        $args['icon'] = 'fa-star-o';
        $args['label'] = 'Рейтинг';
        echo rcl_get_button($args);
    echo '</div>';

  echo '<div style="margin: 12px 0;"></div>';

    echo '- как видим, мы получили кнопку с новой строки';

echo '<hr style="margin: 12px 0;">';

    echo '<br>Но если нам надо кнопку или несколько кнопок выводить иначе - смотрим примеры ниже
    потребуется тег "a" (кнопки) обернуть так:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__***&quot;&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
&lt;/div&gt;
</pre>';

    echo '<strong>rcl-wrap</strong> - задает общий контейнер-обертку. После него надо дописывать еще модификатор.<br>';
    echo 'Почему я выбрал имя, например: <strong>rcl-wrap__right</strong>, а не rcl-wrap__bttn-right? Потому что контейнер обертку для позиционирования можно будет использовать не только для кнопок. А вообще глобально (картинки, другие блоки...) - используя единые стили и значит писать меньше стилей придется<br>';

    echo '<div style="margin: 12px 0;"></div>';
    echo '<h5>одна кнопка - справа:</h5>';

    echo 'Структура:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__right&quot;&gt;
    &lt;a&gt;&lt;/a&gt;
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__right">';
        $args['icon'] = 'fa-id-badge';
        $args['label'] = 'В кабинет';
        echo rcl_get_button($args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';

    echo '<h5>Кнопки - справа:</h5>';
    echo 'Структура:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__right&quot;&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
    ...
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__right">';
        $args['icon'] = '';
        $args['label'] = 'В кабинет';
        echo rcl_get_button($args);

        $args['icon'] = 'fa-car';
        $args['label'] = 'Подобрать авто';
        echo rcl_get_button($args);

        $args['icon_align'] = 'right';
        $args['icon'] = 'fa-plane';
        $args['label'] = 'Подобрать билет';
        echo rcl_get_button($args);

        $args['icon_align'] = '';
        $args['icon'] = 'fa-star-o';
        echo rcl_get_button($args);

        $args['label'] = '';
        $args['icon'] = 'fa-heart-o';
        echo rcl_get_button($args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';

    echo '<h5>Кнопки вертикально - справа:</h5>';

    echo 'Структура:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__right rcl-wrap__vertical&quot;&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__right rcl-wrap__vertical">';
        $args['icon'] = 'fa-star-o';
        echo rcl_get_button($args);

        $args['icon'] = 'fa-car';
        $args['label'] = 'Подобрать авто';
        echo rcl_get_button($args);

        $args['icon'] = 'fa-plane';
        $args['label'] = 'Подобрать билет на май';
        echo rcl_get_button($args);
    echo '</div>';

    echo '- в этом случае блок позиционируется справа, а кнопки выровнены по левому краю. Если надо их вывести на всю ширину или по центру (при расположении обертки справа и в вертикальном представлении кнопок конечно же) - пишите свои стили. т.к. в этом блоке могут быть разные типы кнопок (с иконками и без, текстовые или нет, ну и так далее) - тут тонко самостоятельно настраивайте под свои задачи.';

echo '<hr style="margin: 12px 0;">';

    echo '<h5>Кнопки вертикально - слева:</h5>';

    echo 'Структура:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__vertical&quot;&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
    &lt;a&gt;&lt;/a&gt;
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__vertical">';
        $args['icon'] = 'fa-star-o';
        $args['label'] = '';
        echo rcl_get_button($args);

        $args['icon'] = 'fa-car';
        $args['label'] = 'Подобрать авто';
        echo rcl_get_button($args);

        $args['icon'] = 'fa-plane';
        $args['label'] = 'Подобрать билет на май';
        echo rcl_get_button($args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';

$args['icon'] = '';

    echo '<h5>Специальный стиль:</h5>';

    echo 'Идеально подойдет для сайдбаров и виджетов, для меню. Готовый к использованию напоминает виджеты ютуба<br>';
    echo 'p.s. ширину здесь я специально ограничил 350px - в стилях апи кнопок ее нет - полная ширина. Учитывайте это.<br>';

    echo 'Структура:
<pre>
&lt;div class=&quot;rcl-wrap rcl-wrap__wiget&quot style=&quotwidth: 350px;&quot;&gt;
  &lt;php
    $args["size"] = "medium";
    $args["type"] = "clear";

    $args["avatar"] = get_avatar(1, 26);
    $args["counter"] = "3";
    $args["label"] = "Otshelnik-Fm";
    echo rcl_get_button($args);
  ?&gt;
    ...
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__wiget" style="width: 350px;">';
        $args['size'] = 'medium';
        $args['type'] = 'clear';

        $args['avatar'] = get_avatar(1, 26);
        $args['counter'] = '3';
        $args['label'] = 'Otshelnik-Fm';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(3, 26);
        $args['counter'] = '87';
        $args['label'] = 'Надежда Великолепная';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(2, 26);
        $args['counter'] = '';
        $args['label'] = 'Путешественник во времени';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(108, 26);
        $args['counter'] = '71';
        $args['label'] = 'Андрей Плечёв';
        echo rcl_get_button($args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';

echo '<strong>rcl-bttn__ava_circle</strong> - передается в $args["class"]<br>';

echo 'т.е. у нас будет все как выше только в одном аргументе изменение - добавили модификатор кнопке<br>';
echo '
<pre>
    $args["class"] = "rcl-bttn__size-medium rcl-bttn__ava_circle";
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__wiget" style="width: 350px;">';
        $args['type'] = 'clear';
        $args['size'] = 'medium';
        $args['avatar_circle'] = 1;

        $args['avatar'] = get_avatar(1, 26);
        $args['counter'] = '3';
        $args['label'] = 'Otshelnik-Fm';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(3, 26);
        $args['counter'] = '87';
        $args['label'] = 'Надежда Великолепная';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(2, 26);
        $args['counter'] = '';
        $args['label'] = 'Путешественник во времени';
        echo rcl_get_button($args);

        $args['avatar'] = get_avatar(108, 26);
        $args['counter'] = '71';
        $args['label'] = 'Андрей Плечёв';
        echo rcl_get_button($args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_wrappers');



// состояния кнопок
function vdss_state_button(){
  echo '<br/>';
    echo '<h2>Использование состояний кнопок:</h2>';
echo '<hr style="margin: 12px 0;">';

    echo '<h5>Load:</h5>';

    echo 'Для показа что кнопка сейчас работает и что-то вернет.<br>';
    echo 'Добавьте в агрумент класса <strong>rcl-bttn__loading</strong>: $args["status"] = "loading"<br>';

    $args['status'] = 'loading';

    $args['type'] = 'clear';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет на май';
    echo rcl_get_button($args);

    $args['type'] = '';
    $args['size'] = 'big';
    $args['icon'] = 'fa-star-o';
    $args['label'] = '';
    echo rcl_get_button($args);

    $args['type'] = 'simple';
    $args['size'] = 'medium';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

$args['icon'] = '';
echo '<hr style="margin: 12px 0;">';

    echo '<h5>Disabled:</h5>';

    echo 'Добавьте в агрумент класса <strong>rcl-bttn__disabled</strong>: $args["status"] = "disabled"<br>';

    echo '<strong>Пагинация:</strong><br/>';

    $args['status'] = '';
    $args['size'] = 'large';

    $args['label'] = '1';
    echo rcl_get_button($args);

    $args['label'] = '2';
    echo rcl_get_button($args);

    $args['label'] = '3';
    echo rcl_get_button($args);

    $args['label'] = '...';
    $args['status'] = 'disabled';
    echo rcl_get_button($args);

    $args['status'] = '';
    $args['label'] = '22';
    echo rcl_get_button($args);

    $args['label'] = '23';
    echo rcl_get_button($args);


echo '<hr style="margin: 12px 0;">';

    echo '<h5>Active:</h5>';

    echo 'Добавьте в агрумент класса <strong>rcl-bttn__active</strong>: $args["status"] = "active"<br>';
    echo '1-я кнопка обычная. Вторая активная.<br><br>';


    $args['type'] = 'clear';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет на май';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['icon'] = 'fa-plane';
    $args['label'] = 'Подобрать билет на май';
    echo rcl_get_button($args);
  echo '<br><br>';

    $args['label'] = '';
    $args['status'] = '';
    $args['type'] = ''; // значит rcl-bttn__type-primary
    $args['size'] = 'big';

    $args['icon'] = 'fa-star-o';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['icon'] = 'fa-star-o';
    echo rcl_get_button($args);
  echo '<br><br>';

    $args['status'] = '';
    $args['size'] = 'medium';
    $args['type'] = 'simple';

    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);
  echo '<br><br>';


    $args['status'] = '';
    $args['size'] = 'large';
    $args['type'] = '';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['icon'] = 'fa-car';
    $args['label'] = 'Подобрать авто';
    echo rcl_get_button($args);
  echo '<br><br>';


    $args['status'] = '';
    $args['icon_mask'] = 1;
    $args['icon_align'] = 'right';
    $args['counter'] = '36';
    $args['icon'] = 'fa-upload';
    $args['label'] = 'Скачать';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['counter'] = '249';
    $args['icon'] = 'fa-sign-out';
    $args['label'] = 'Перейти';
    echo rcl_get_button($args);

echo '<br/><br/>';

    echo '<strong>Пагинация:</strong><br/>';

    $args['status'] = '';
    $args['icon_align'] = '';
    $args['icon_mask'] = '';
    $args['icon'] = '';
    $args['counter'] = '';
    
    $args['type'] = 'simple';
    $args['size'] = 'large';

    $args['label'] = '1';
    echo rcl_get_button($args);

    $args['status'] = 'active';
    $args['label'] = '2';
    echo rcl_get_button($args);

    $args['status'] = '';
    $args['label'] = '3';
    echo rcl_get_button($args);

    $args['status'] = 'disabled';
    $args['label'] = '...';
    echo rcl_get_button($args);

    $args['status'] = '';
    $args['label'] = '22';
    echo rcl_get_button($args);

    $args['label'] = '23';
    echo rcl_get_button($args);

echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_state_button');






