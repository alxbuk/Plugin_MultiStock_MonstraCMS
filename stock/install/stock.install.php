<?php defined('MONSTRA_ACCESS') or die('No direct script access.');

    Option::add('st_w', 165); 
    Option::add('st_h', 100);
    Option::add('st_wmax', 900); 
    Option::add('st_hmax', 800);
    Option::add('st_resize', 'crop');
    
    Table::create('stock', array('name', 'w', 'h', 'wmax', 'hmax', 'resize')); 
    
    $dir = ROOT . DS . 'public' . DS . 'stock' . DS;  
    if(!is_dir($dir)) mkdir($dir, 0755);