<?php 

    // Admin Navigation: add new item
    Navigation::add(__('Stock', 'stock'), 'content', 'stock', 10);
    

    // Add actions
    Action::add('admin_pre_render','StockAdmin::ajaxSave');
    
    Javascript::add('plugins/stock/stock/admin.js', 'backend', 11);
    
    /**
     * Stock admin class
     */
    class StockAdmin extends Backend {
        
	    public static function main() {  
            
            $resize_way = array(
                'width'   => __('Respect to the width', 'stock'),
                'height'  => __('Respect to the height', 'stock'),
                'crop'    => __('Similarly, cutting unnecessary', 'stock'),
                'stretch' => __('Similarly with the expansion', 'stock'), 
            );
            
            $dir = ROOT . DS . 'public' . DS . 'stock' . DS;            
            $stock = new Table('stock');
            $siteurl = Option::get('siteurl');
            
            /**
             * Delete photo
             */
            if(Request::get('delete_img') and Request::get('album_id')) {
                if (Security::check(Request::get('token'))) {
                    $thumbs = $dir . Request::get('album_id') . DS . 'thumbs' . DS;
                    $original = $dir . Request::get('album_id') . DS . 'original' . DS;
                    unlink($thumbs . Request::get('delete_img'));
                    unlink($original . Request::get('delete_img'));
                    Request::redirect('index.php?id=stock&album_id='.Request::get('album_id'));
                }
            }
            
            /**
             * Delete album
             */
            if(Request::get('delete_album')) {
                if (Security::check(Request::get('token'))) {
                    $album_id = (int)Request::get('delete_album');
                    
                    $stock->delete($album_id);
                    
                    $album = $dir . $album_id . DS;
                    $thumbs = $album . 'thumbs' . DS;
                    $original = $album . 'original' . DS;
                
                    if ($objs = glob($thumbs."*"))   foreach($objs as $obj) unlink($obj);
                    if ($objs = glob($original."*")) foreach($objs as $obj) unlink($obj);
                    
                    rmdir($thumbs);
                    rmdir($original);
                    rmdir($album);
                    
                    Request::redirect('index.php?id=stock');
                }
            }
            
            /**
             * Add album
             */
            if (Request::post('submit_album_add')) {
                if (Security::check(Request::post('csrf'))) {
                    $w = (int)Request::post('width_thumb');
                    $h = (int)Request::post('height_thumb');
                    $wmax = (int)Request::post('width_orig');
                    $hmax = (int)Request::post('height_orig');
                    $resize = (string)Request::post('resize_way');
                    $name = (string)Request::post('name');
                    
                    if(empty($name)) $name = __('No title', 'stock');
                    
                    $stock->insert(array('name'=>$name, 'w'=>$w, 'h'=>$h, 'wmax'=>$wmax, 'hmax'=>$hmax, 'resize'=>$resize));
                    
                    $lastid = $stock->lastId();
                    
                    $album_dir = $dir . $lastid . DS;
                    $album_dir_thumbs = $album_dir . 'thumbs' . DS;
                    $album_dir_original = $album_dir . 'original' . DS;
                    
                    if(!is_dir($album_dir)) mkdir($album_dir, 0755);
                    if(!is_dir($album_dir_thumbs)) mkdir($album_dir_thumbs, 0755);
                    if(!is_dir($album_dir_original)) mkdir($album_dir_original, 0755);
                    
                    Request::redirect('index.php?id=stock&album_id='.$lastid);
                } else { die('csrf detected!'); }
            }
            
            /**
             *  Upload image
             */   
            if (Request::post('upload_file')) {
                if (Security::check(Request::post('csrf'))) { 
                    if ($_FILES['file']) {
                        if($_FILES['file']['type'] == 'image/jpeg' ||
                            $_FILES['file']['type'] == 'image/png' ||
                            $_FILES['file']['type'] == 'image/gif') {
                   
                            $name = Text::random('alnum', 10).'.jpg';
                            $img  = Image::factory($_FILES['file']['tmp_name']);
                            $album_id = (int)Request::post('album_id');
                            
                            $album = $stock->select('[id='.$album_id.']', 1);
                            $album = $album[0];
                            
                            $wmax   = (int)$album['wmax'];
                            $hmax   = (int)$album['hmax'];
                            $width  = (int)$album['w'];
                            $height = (int)$album['h'];
                            $resize = $album['resize'];
                            
                            $original = $dir . $album_id . DS . 'original' . DS;
                            $thumbs = $dir . $album_id . DS . 'thumbs' . DS;
                            
                            $ratio = $width/$height;
                            
                            if ($img->width > $wmax or $img->height > $hmax) {
                                if ($img->height > $img->width) {
                                    $img->resize($wmax, $hmax, Image::HEIGHT);
                                } else {
                                    $img->resize($wmax, $hmax, Image::WIDTH);
                                }
                            }
                            $img->save($original . $name);
                            
                            switch ($resize) {
                                case 'width' :   $img->resize($width, $height, Image::WIDTH);  break;
                                case 'height' :  $img->resize($width, $height, Image::HEIGHT); break;
                                case 'stretch' : $img->resize($width, $height); break;
                                default : 
                                    // crop
                                    if (($img->width/$img->height) > $ratio) {
                                        $img->resize($width, $height, Image::HEIGHT)->crop($width, $height, round(($img->width-$width)/2),0);
                                    } else {
                                        $img->resize($width, $height, Image::WIDTH)->crop($width, $height, 0, 0);
                                    }
                                    break;
                            }
                            $img->save($thumbs . $name);
                        }
                    }
                    Request::redirect('index.php?id=stock&album_id='.$album_id);
                } else { die('csrf detected!'); }
            }
            
            /**
             * Actions
             */
            if (Request::get('action')) {
                switch (Request::get('action')) {
                    case 'addalbum': View::factory('stock/views/backend/album_add')->assign('resize_way', $resize_way)->display(); break;
                    case 'settings': View::factory('stock/views/backend/settings')->assign('resize_way', $resize_way)->display(); break;
                }
            } else {
                if(Request::get('album_id')) {
                    $album = $stock->select('[id='.(int)Request::get('album_id').']');
                    $album = $album[0];
                    Notification::setNow('upload', 'upload!');
                    
                    $files = File::scan($dir . $album['id'] . DS . 'thumbs' . DS , 'jpg');

                    View::factory('stock/views/backend/album')
                        ->assign('album', $album)
                        ->assign('resize_way', $resize_way)
                        ->assign('files', $files)
                        ->assign('path_orig', $siteurl.'public/stock/'.$album['id'].'/original/')
                        ->assign('path_thumb', $siteurl.'public/stock/'.$album['id'].'/thumbs/')
                        ->display();
                } else {
                    $records = $stock->select(null, 'all');
                    View::factory('stock/views/backend/index')->assign('records', $records)->display();
                }
            }
	    }
        
        /**
         *  Ajax save
         */ 
        public static function ajaxSave() {
        
            // save settings
            if (Request::post('stock_submit_settings')) {
                if (Security::check(Request::post('csrf'))) {
                    Option::update(array(
                        'st_w' => (int)Request::post('width_thumb'), 
                        'st_h' => (int)Request::post('height_thumb'),
                        'st_wmax'   => (int)Request::post('width_orig'),
                        'st_hmax'   => (int)Request::post('height_orig'),
                        'st_resize' => (string)Request::post('resize_way')
                    ));
                    exit('<b>'.__('Resize success!', 'stock').'</b>');
                } else { die('csrf detected!'); }
            }
            
            // save album edit
            if (Request::post('stock_submit_album_edit')) {
                if (Security::check(Request::post('csrf'))) {
                    
                    $w = (int)Request::post('width_thumb');
                    $h = (int)Request::post('height_thumb');
                    $wmax = (int)Request::post('width_orig');
                    $hmax = (int)Request::post('height_orig');
                    $resize = (string)Request::post('resize_way');
                    $name = (string)Request::post('name');
                    $album_id = (int)Request::post('album_id');
                    
                    if(empty($name)) $name = __('No title', 'stock');
                    
                    $stock = new Table('stock');
                    $stock->update($album_id, array('name'=>$name, 'w'=>$w, 'h'=>$h, 'wmax'=>$wmax, 'hmax'=>$hmax, 'resize'=>$resize));
                    
                    exit('<b>'.__('Resize success!', 'stock').'</b>');
                } else { die('csrf detected!'); }
            }
            
            // photos resize
            if(Request::post('st_resize') and (int)Request::post('album_id')>0) {
                
                $id = (int)Request::post('album_id');
                
                $dir = ROOT . DS . 'public' . DS . 'stock' . DS;  
                $thumbs   = $dir . $id . DS . 'thumbs' . DS;
                $original = $dir . $id . DS . 'original' . DS;
            
                $files = File::scan($thumbs, 'jpg');
                if ($files > 0) {
                    
                    $stock = new Table('stock');
                    $album = $stock->select('[id='.$id.']');
                    $album = $album[0];
                
                    $width  = $album['w'];
                    $height = $album['h'];
                    $resize_way = $album['resize'];
                    $ratio = $width/$height;
                       
                    foreach ($files as $name) {
                        $img = Image::factory($original.$name);
                            
                        switch ($resize_way) {
                            case 'width' : $img->resize($width, $height, Image::WIDTH); break;
                            case 'height' : $img->resize($width, $height, Image::HEIGHT); break;
                            case 'stretch' : $img->resize($width, $height); break;
                            default : 
                                // crop                                    
                                if (($img->width/$img->height) > $ratio) {
                                    $img->resize($width, $height, Image::HEIGHT)->crop($width, $height, round(($img->width-$width)/2),0);
                                } else {
                                    $img->resize($width, $height, Image::WIDTH)->crop($width, $height, 0, 0);
                                }
                                break;
                        }
                        $img->save($thumbs . $name);
                    }
                }
                exit('<b>'.__('Resize success!', 'stock').'</b>');
            }
        }
	}
    
    