<?php
/**
*  Stock plugin
*
*  @package Monstra
*  @subpackage Plugins
*  @author AlxBuk ft Yudin Evgeniy / JINN
*  @copyright 2012 AlxBuk ft Yudin Evgeniy / JINN
*  @version 1.0.0
*
*/
// Register plugin
Plugin::register( __FILE__,                    
__('Stock', 'stock'),
__('MultiStock by AlxBuk', 'stock'),  
'1.0.0',
'AlxBuk ft JINN',                 
'http://alxbuk.ru/');


// Load Stock Admin for Editor and Admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {        
Plugin::admin('stock');
}
if (!BACKEND) Stylesheet::add('plugins/stock/stock/style.css', 'frontend', 11);
Javascript::add('plugins/stock/stock/jquery.colorbox.js', 'frontend', 12);
Javascript::add('plugins/stock/stock/jquery.colorbox.config.js', 'frontend', 13);
Shortcode::add('stock', 'Stock::show');
Shortcode::add('stock_ytb_link', 'Stock_ytb_link::show');
Shortcode::add('stock_ytb_thumb', 'Stock_ytb_thumb::show');
Shortcode::add('stock_vmo_link', 'Stock_vmo_link::show');
Shortcode::add('stock_vmo_thumb', 'Stock_vmo_thumb::show');
Shortcode::add('stock_frame', 'Stock_frame::show');
Shortcode::add('stock_modal', 'Stock_modal::show');

class Stock {
	public static function show($attributes){
		extract($attributes);
		$album_id = (int)$album;
		$siteurl = Option::get('siteurl');
		$original = $siteurl.'public/stock/'.$album_id.'/original/';
		$thumbs = $siteurl.'public/stock/'.$album_id.'/thumbs/';
		$title = '';
		if(isset($img)) {
		// current img
		return '<a href="'.$original.$img.'" class="group1" title="'.$title.'"><img class="stock_current" src="'.$thumbs.$img.'" alt="'.$title.'" title="Нажми чтобы увеличить"/></a>';
		} else {
			// show album
			$files = File::scan(ROOT . DS . 'public' . DS . 'stock' . DS . $album_id . DS . 'thumbs' . DS, 'jpg');                
			$count = count($files);
			$html = '<div class="stock">';
			for($i=0;$i<$count;$i++) $html.= '<a href="'.$original.$files[$i].'" class="group1"><img class="stock_current" src="'.$thumbs.$files[$i].'" alt="" title="Нажми чтобы увеличить"/></a>';
			$html.= '</div>';
			return $html;
		}
	}
}

class Stock_ytb_link {
	public static function show($attributes){
		extract($attributes);
		$codeyto = $code;
		if(isset($title)) {return '<a href="http://www.youtube.com/embed/'.$codeyto.'" class="youtube" title="'.$title.'">'.$title.'</a>';}
	}
}

class Stock_ytb_thumb {
	public static function show($attributes){
		extract($attributes);
		$codeyto = $code;
		if(isset($title)) {return '<a href="http://www.youtube.com/embed/'.$codeyto.'" class="youtube" title="'.$title.'"><img class="stock_current" src="http://i4.ytimg.com/vi/'.$codeyto.'/default.jpg" alt=""/></a>';}
	}
}

class Stock_vmo_link {
	public static function show($attributes){
		extract($attributes);
		$codeyto = $code;
		if(isset($title)) {return '<a href="http://player.vimeo.com/video/'.$codeyto.'" class="vimeo" title="'.$title.'">'.$title.'</a>';}
	}
}
class Stock_vmo_thumb {
	public static function show($attributes){
		extract($attributes);
		$codeyto = $code;
		$linkthumb = $thumb;
		if(isset($title)) {return '<a href="http://player.vimeo.com/video/'.$codeyto.'" class="vimeo"><img class="stock_current" src="'.$linkthumb.'" alt=""/></a>';}
	}
}
class Stock_frame {
	public static function show($attributes){
		extract($attributes);
		$urllink = $url;
		if(isset($title)) {return '<a class="iframe" href="'.$urllink.'" title="'.$urllink.' - '.$title.'">'.$title.'</a>';}
	}
}

class Stock_modal {
	public static function show($attributes){
		extract($attributes);
		$divid = $div;
		if(isset($title)) {return '<a class="inline" href="#'.$divid.'">'.$title.'</a>';}
	}
}
