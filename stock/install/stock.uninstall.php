<?php defined('MONSTRA_ACCESS') or die('No direct script access.');
    
    Option::delete('st_w');
    Option::delete('st_h');
    Option::delete('st_wmax');
    Option::delete('st_hmax');
    Option::delete('st_resize');
    
    Table::drop('stock');