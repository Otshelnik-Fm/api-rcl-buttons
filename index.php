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
add_action('wp_enqueue_scripts','apib_load_resource',10);




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
$args['ava']    // <img alt='' src='...
$args['count']  // 12
$args['ricon']  // иконка справа
*/
if(is_array($args)){
    $args = array_filter($args); // unset $args[key] = '';
} else {
    $args = array();
}


$dop_class = ''; // доп классы для возможности стилизации кнопки в зависимости от ее состава
if( isset($bttn_text) && array_key_exists('ricon', $args) && empty($args['count']) ){ // кнопка из текста и только иконки справа
    //if( !empty($args['ricon']) ) {
        $dop_class = 'rcl-bttn__mod-text-rico';
    //}
}
else if ( isset($bttn_text) && array_key_exists('ricon', $args) && array_key_exists('count', $args) && empty($args['ava']) ){
    //if( !empty($args['ricon']) && !empty($args['count']) ) { // текст иконка справа и счетчик
        $dop_class = 'rcl-bttn__mod-text-rico-count';
    //}
}
else if ( empty($bttn_text) && array_key_exists('icon', $args) && empty($args['count']) && empty($args['ricon']) && empty($args['ava']) ){
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

        if(isset($args['ava'])&&$args['ava']) $button .= '<i class="rcl-bttn__ava">'.$args['ava'].'</i>';

        if($bttn_text) $button .= '<span class="rcl-bttn__text">'.$bttn_text.'</span>';

        if(isset($args['ricon'])&&$args['ricon']) $button .= '<i class="rcl-bttn__ico rcl-bttn__ico-right"><svg class="uspic-icon '.$args['ricon'].'"><use xlink:href="#'.$args['ricon'].'"></use></svg></i>';

        if(isset($args['count'])&&$args['count']) $button .= '<span class="rcl-bttn__count">'.$args['count'].'</span>';


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
    $args['icon'] = 'uspic-portrait';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'uspic-favorite_border';
    $args['count'] = '31';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['count'] = '2';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    $args['count'] = '156';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    $args['title'] = 'Перейти в кабинет';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['title'] = '';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args=false);

    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args=false);

    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args=false);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';
    $args['count'] = '31';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '421';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '7';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon'] = '';
    $args['ricon'] = 'uspic-arrow_forward';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ricon'] = 'uspic-arrow_downward';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['ricon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['count'] = '2398';
    $args['ricon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text='Рейтинг',$url=false,$args);

    $args['count'] = '74';
    $args['ricon'] = 'uspic-chat';
    echo svg_get_button($bttn_text='Комментариев',$url=false,$args);

    $args['count'] = '21';
    $args['ricon'] = 'uspic-handshake';
    echo svg_get_button($bttn_text='Друзей',$url=false,$args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['count'] = '';
    $args['ricon'] = '';
    $args['ava'] = get_avatar(1, 26);
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(3, 26);
    $args['count'] = '7';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(2, 26);
    $args['count'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['ava'] = get_avatar(108, 26);
    $args['count'] = '';
    $args['title'] = '';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<hr style="margin: 12px 0;">';

}
add_action('apib_button','all_buttons1');




// дизайн кнопок - простой
function all_buttons_simple(){
echo '<hr style="margin: 12px 0;">';
echo '<div style="margin: 12px 0;"></div>';
echo '<hr style="margin: 12px 0;">';
    echo '<h5>Тип кнопки "rcl-bttn__type-simple" - без модификаторов</h5>';

    echo '"rcl-bttn__type-simple" - это простая кнопка с обводкой. <br>';
    echo 'Данная кнопка подойдет на большинство дизайнов сайта - как нейтральная. Постраничная навигация может быть сделана этими кнопками<br>';
    echo 'Здесь собраны все существующие виды кнопок. Размер дефолтный. Никаких модификаторов:<br/>';

echo '<hr style="margin: 12px 0;">';

    echo '<strong>иконка:</strong><br/>';
    $args['type'] = 'rcl-bttn__type-simple';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'uspic-favorite_border';
    $args['count'] = '31';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['count'] = '2';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    $args['count'] = '156';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    $args['title'] = 'Перейти в кабинет';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['title'] = '';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';

    $args['count'] = '';
    $args['icon'] = '';
    $args['type'] = 'rcl-bttn__type-simple';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>Пагинация (тоже текст):</strong><br/>';

    echo svg_get_button($bttn_text='1',$url=false,$args);
    echo svg_get_button($bttn_text='2',$url=false,$args);
    echo svg_get_button($bttn_text='3',$url=false,$args);
    echo svg_get_button($bttn_text='...',$url=false,$args);
    echo svg_get_button($bttn_text='22',$url=false,$args);
    echo svg_get_button($bttn_text='23',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';
    $args['count'] = '31';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '421';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '7';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon'] = '';
    $args['ricon'] = 'uspic-arrow_forward';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ricon'] = 'uspic-arrow_downward';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['ricon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['count'] = '2398';
    $args['ricon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text='Рейтинг',$url=false,$args);

    $args['count'] = '74';
    $args['ricon'] = 'uspic-chat';
    echo svg_get_button($bttn_text='Комментариев',$url=false,$args);

    $args['count'] = '21';
    $args['ricon'] = 'uspic-handshake';
    echo svg_get_button($bttn_text='Друзей',$url=false,$args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['count'] = '';
    $args['ricon'] = '';
    $args['ava'] = get_avatar(1, 26);
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(3, 26);
    $args['count'] = '7';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(2, 26);
    $args['count'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['ava'] = get_avatar(108, 26);
    $args['count'] = '';
    $args['title'] = '';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<hr style="margin: 12px 0;">';

}
add_action('apib_button','all_buttons_simple');




// кнопки без дизайна
function all_buttons_clear(){
echo '<hr style="margin: 12px 0;">';
echo '<div style="margin: 12px 0;"></div>';
echo '<hr style="margin: 12px 0;">';
    echo '<h5>Тип кнопки "rcl-bttn__type-clear" - без модификаторов</h5>';

    echo '"rcl-bttn__type-clear" - это простая кнопка без фонового цвета. Как ссылка.<br>';
    echo 'Данная кнопка будет полезна чтобы задавать свои стили или для использования в вертикальных группах<br>';
    echo 'Здесь собраны все существующие виды кнопок. Размер дефолтный. Никаких модификаторов:<br/>';

echo '<hr style="margin: 12px 0;">';

    echo '<strong>иконка:</strong><br/>';
    $args['type'] = 'rcl-bttn__type-clear';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - счётчик:</strong><br/>';
    $args['icon'] = 'uspic-favorite_border';
    $args['count'] = '31';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['count'] = '2';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    $args['count'] = '156';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    $args['title'] = 'Перейти в кабинет';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    $args['title'] = '';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);


echo '<hr style="margin: 12px 0;">';

    echo '<strong>текст:</strong><br/>';

    $args['count'] = '';
    $args['icon'] = '';
    $args['type'] = 'rcl-bttn__type-clear';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - счётчик:</strong><br/>';
    $args['count'] = '31';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '421';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '7';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>иконка - текст:</strong><br/>';
    $args['count'] = '';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа:<br/></strong>';
    $args['icon'] = '';
    $args['ricon'] = 'uspic-arrow_forward';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ricon'] = 'uspic-arrow_downward';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['ricon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<div style="margin: 12px 0;"></div>';

    echo '<strong>текст - иконка справа - счётчик:<br/></strong>';
    $args['count'] = '2398';
    $args['ricon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text='Рейтинг',$url=false,$args);

    $args['count'] = '74';
    $args['ricon'] = 'uspic-chat';
    echo svg_get_button($bttn_text='Комментариев',$url=false,$args);

    $args['count'] = '21';
    $args['ricon'] = 'uspic-handshake';
    echo svg_get_button($bttn_text='Друзей',$url=false,$args);

echo '<hr style="margin: 12px 0;">';

    echo '<strong>ава - текст, ава - текст - счетчик, ава - счетчик - тайтл, просто ава:<br/></strong>';

    $args['count'] = '';
    $args['ricon'] = '';
    $args['ava'] = get_avatar(1, 26);
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(3, 26);
    $args['count'] = '7';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['ava'] = get_avatar(2, 26);
    $args['count'] = '71';
    $args['title'] = 'Перейти в кабинет Надежда';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['ava'] = get_avatar(108, 26);
    $args['count'] = '';
    $args['title'] = '';
    echo svg_get_button($bttn_text=false,$url=false,$args);

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

    echo '<h5>Размеры:</h5>';
    echo 'Если нет класса - то это равносильно rcl-bttn__size-standart.<br/>';
    echo '<strong>без доп класса | rcl-bttn__size-medium | rcl-bttn__size-large | rcl-bttn__size-big:</strong><br/>';

    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);


    $args['class'] = 'rcl-bttn__size-medium';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);


    $args['class'] = 'rcl-bttn__size-large';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);


    $args['class'] = 'rcl-bttn__size-big';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<hr style="margin: 12px 0;">';

    $args['class'] = '';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-medium';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-large';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-big';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<hr style="margin: 12px 0;">';

    $args['type'] = 'rcl-bttn__type-clear';
    $args['class'] = '';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-medium';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-large';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-big';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';


echo '<hr style="margin: 12px 0;">';

    $args['count'] = '';
    $args['class'] = 'rcl-bttn__size-standart';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

  echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-medium';
    echo svg_get_button($bttn_text=false,$url=false,$args);

  echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-large';
    echo svg_get_button($bttn_text=false,$url=false,$args);

  echo '<br/><br/>';

    $args['class'] = 'rcl-bttn__size-big';
    echo svg_get_button($bttn_text=false,$url=false,$args);

echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_sizes');



// иконка - текст полная ширина
function vdss_button_fullwidth(){
  echo '<br/>';
    echo '<h5>Полная ширина:</h5>';
    echo 'Указание <strong>rcl-bttn__fullwidth</strong><br>';

    $args['icon'] = 'uspic-portrait';
    $args['class'] = 'rcl-bttn__fullwidth';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_button_fullwidth');



// маска на иконке
function vdss_button_mask(){
  echo '<br/>';
    echo '<h5>Маска на иконке:</h5>';

    echo 'класс: <strong>rcl-bttn__ico-mask</strong> и rcl-bttn__size-medium<br/>';

    $args['class'] = 'rcl-bttn__size-medium rcl-bttn__ico-mask';
    $args['icon'] = 'uspic-favorite_border';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    echo 'текст - иконка справа и <strong>rcl-bttn__ico-mask</strong> и rcl-bttn__size-medium';
echo '<br/>';
    // текст - иконка справа
    $args['icon'] = '';
    $args['ricon'] = 'uspic-arrow_downward';
    $args['title'] = 'Скачать файл';
    echo svg_get_button($bttn_text='Скачать',$url=false,$args);

    $args['ricon'] = 'uspic-arrow_forward';
    $args['title'] = 'Нажмите чтобы продолжить';
    echo svg_get_button($bttn_text='Перейти',$url=false,$args);

echo '<br/><br/>';

    echo '<strong>иконка - текст - счётчики:</strong><br/>';
    $args['title'] = '';
    $args['ricon'] = '';
    $args['count'] = '12';
    $args['icon'] = 'uspic-edit_copy';
    echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

    $args['count'] = '99';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['count'] = '652';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

echo '<br/><br/>';

    echo '<strong>текст, иконка - счётчики (группируются):</strong><br/>';
    $args['icon'] = '';
    $args['count'] = '36';
    $args['ricon'] = 'uspic-arrow_downward';
    echo svg_get_button($bttn_text='Скачать',$url=false,$args);

    $args['count'] = '249';
    $args['ricon'] = 'uspic-arrow_forward';
    echo svg_get_button($bttn_text='Перейти',$url=false,$args);

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
        $args['icon'] = 'uspic-edit_copy';
        echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

  echo '<div style="margin: 12px 0;"></div>';

    echo '<br><strong>Пример c wrapper:</strong><br>';

    echo 'какой-то текст и мы решили вставить просто кнопку ';
        echo '<div class="rcl-wrap">';
        $args['icon'] = 'uspic-star_border';
        echo svg_get_button($bttn_text='Рейтинг',$url=false,$args);
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
        $args['icon'] = 'uspic-edit_copy';
        echo svg_get_button($bttn_text='В кабинет',$url=false,$args);
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
        echo svg_get_button($bttn_text='В кабинет',$url=false,$args);

        $args['icon'] = 'uspic-car';
        echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

        $args['icon'] = '';
        $args['ricon'] = 'uspic-flight';
        echo svg_get_button($bttn_text='Подобрать билет',$url=false,$args);

        $args['ricon'] = '';
        $args['icon'] = 'uspic-star_border';
        echo svg_get_button($bttn_text=false,$url=false,$args);
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
        $args['icon'] = 'uspic-star_border';
        echo svg_get_button($bttn_text=false,$url=false,$args);

        $args['icon'] = 'uspic-car';
        echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

        $args['icon'] = 'uspic-flight';
        echo svg_get_button($bttn_text='Подобрать билет на май',$url=false,$args);
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
        $args['icon'] = 'uspic-star_border';
        echo svg_get_button($bttn_text=false,$url=false,$args);

        $args['icon'] = 'uspic-car';
        echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

        $args['icon'] = 'uspic-flight';
        echo svg_get_button($bttn_text='Подобрать билет на май',$url=false,$args);
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
    $args["class"] = "rcl-bttn__size-medium";
    $args["type"] = "rcl-bttn__type-clear";
    $args["ava"] = get_avatar(1, 26);
    $args["count"] = "3";
    echo svg_get_button($bttn_text="Otshelnik-Fm",$url=false,$args);
  ?&gt;
    ...
&lt;/div&gt;
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__wiget" style="width: 350px;">';
        $args['class'] = 'rcl-bttn__size-medium';
        $args['type'] = 'rcl-bttn__type-clear';
        $args['ava'] = get_avatar(1, 26);
        $args['count'] = '3';
        echo svg_get_button($bttn_text='Otshelnik-Fm',$url=false,$args);

        $args['ava'] = get_avatar(3, 26);
        $args['count'] = '87';
        echo svg_get_button($bttn_text='Надежда Великолепная',$url=false,$args);

        $args['ava'] = get_avatar(2, 26);
        $args['count'] = '';
        echo svg_get_button($bttn_text='Путешественник во времени',$url=false,$args);

        $args['ava'] = get_avatar(108, 26);
        $args['count'] = '71';
        echo svg_get_button($bttn_text='Андрей Плечёв',$url=false,$args);
    echo '</div>';

echo '<hr style="margin: 12px 0;">';

echo '<strong>rcl-bttn__ava_circle</strong> - передается в $args["class"]<br>';

echo 'т.е. у нас будет все как выше только в одном аргументе изменение - добавили модификатор кнопке<br>';
echo '
<pre>
    $args["class"] = "rcl-bttn__size-medium rcl-bttn__ava_circle";
</pre>';

    echo '<div class="rcl-wrap rcl-wrap__wiget" style="width: 350px;">';
        $args['class'] = 'rcl-bttn__size-medium rcl-bttn__ava_circle';
        $args['type'] = 'rcl-bttn__type-clear';
        $args['ava'] = get_avatar(1, 26);
        $args['count'] = '3';
        echo svg_get_button($bttn_text='Otshelnik-Fm',$url=false,$args);

        $args['ava'] = get_avatar(3, 26);
        $args['count'] = '87';
        echo svg_get_button($bttn_text='Надежда Великолепная',$url=false,$args);

        $args['ava'] = get_avatar(2, 26);
        $args['count'] = '';
        echo svg_get_button($bttn_text='Путешественник во времени',$url=false,$args);

        $args['ava'] = get_avatar(108, 26);
        $args['count'] = '71';
        echo svg_get_button($bttn_text='Андрей Плечёв',$url=false,$args);
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

    echo 'Для показа что кнопка сейчас работает и что-то вернет.<br> Добавьте в агрумент класса <strong>rcl-bttn__loading</strong>: $args["class"] = "rcl-bttn__loading"<br>';

    $args['type'] = 'rcl-bttn__type-clear';
    $args['class'] = 'rcl-bttn__loading';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет на май',$url=false,$args);

    $args['type'] = '';
    $args['class'] = 'rcl-bttn__size-big rcl-bttn__loading';
    $args['icon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['type'] = 'rcl-bttn__type-simple';
    $args['class'] = 'rcl-bttn__size-medium rcl-bttn__loading';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

$args['icon'] = '';
echo '<hr style="margin: 12px 0;">';

    echo '<h5>Disabled:</h5>';

    echo 'Добавьте в агрумент класса <strong>rcl-bttn__disabled</strong>: $args["class"] = "rcl-bttn__disabled"<br>';

    echo '<strong>Пагинация:</strong><br/>';

    $args['class'] = 'rcl-bttn__size-large';

    echo svg_get_button($bttn_text='1',$url=false,$args);
    echo svg_get_button($bttn_text='2',$url=false,$args);
    echo svg_get_button($bttn_text='3',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large rcl-bttn__disabled';
    echo svg_get_button($bttn_text='...',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large';
    echo svg_get_button($bttn_text='22',$url=false,$args);
    echo svg_get_button($bttn_text='23',$url=false,$args);


echo '<hr style="margin: 12px 0;">';

    echo '<h5>Active:</h5>';

    echo 'Добавьте в агрумент класса <strong>rcl-bttn__active</strong>: $args["class"] = "rcl-bttn__active"<br>';
    echo '1-я кнопка обычная. Вторая активная.<br><br>';

    $args['class'] = '';
    $args['type'] = 'rcl-bttn__type-clear';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет на май',$url=false,$args);

    $args['class'] = 'rcl-bttn__active';
    $args['icon'] = 'uspic-flight';
    echo svg_get_button($bttn_text='Подобрать билет на май',$url=false,$args);
  echo '<br><br>';


    $args['type'] = ''; // значит rcl-bttn__type-primary
    $args['class'] = 'rcl-bttn__size-big';
    $args['icon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);

    $args['class'] = 'rcl-bttn__size-big rcl-bttn__active';
    $args['icon'] = 'uspic-star_border';
    echo svg_get_button($bttn_text=false,$url=false,$args);
  echo '<br><br>';


    $args['class'] = 'rcl-bttn__size-medium';
    $args['type'] = 'rcl-bttn__type-simple';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-medium rcl-bttn__active';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);
  echo '<br><br>';


    $args['class'] = 'rcl-bttn__size-large';
    $args['type'] = '';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large rcl-bttn__active';
    $args['icon'] = 'uspic-car';
    echo svg_get_button($bttn_text='Подобрать авто',$url=false,$args);
  echo '<br><br>';


    $args['class'] = 'rcl-bttn__ico-mask';
    $args['icon'] = '';
    $args['count'] = '36';
    $args['ricon'] = 'uspic-arrow_downward';
    echo svg_get_button($bttn_text='Скачать',$url=false,$args);

    $args['class'] = 'rcl-bttn__ico-mask rcl-bttn__active';
    $args['count'] = '249';
    $args['ricon'] = 'uspic-arrow_forward';
    echo svg_get_button($bttn_text='Перейти',$url=false,$args);

echo '<br/><br/>';

    echo '<strong>Пагинация:</strong><br/>';

    $args['ricon'] = '';
    $args['count'] = '';
    $args['icon'] = '';
    $args['type'] = 'rcl-bttn__type-simple';
    $args['class'] = 'rcl-bttn__size-large';

    echo svg_get_button($bttn_text='1',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large rcl-bttn__active';
    echo svg_get_button($bttn_text='2',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large';
    echo svg_get_button($bttn_text='3',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large rcl-bttn__disabled';
    echo svg_get_button($bttn_text='...',$url=false,$args);

    $args['class'] = 'rcl-bttn__size-large';
    echo svg_get_button($bttn_text='22',$url=false,$args);
    echo svg_get_button($bttn_text='23',$url=false,$args);

echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
echo '<hr style="margin: 12px 0;">';
}
add_action('apib_button','vdss_state_button');






