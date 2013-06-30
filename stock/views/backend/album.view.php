<h2><?php echo __('Album', 'stock').': "'.$album['name'].'"';?></h2>

<ul class="breadcrumb">
    <li><a href="index.php?id=stock"><?php echo __('Stock', 'stock');?></a> <span class="divider">/</span></li>
    <li class="active"><?php echo $album['name'];?></li>
</ul>

<ul class="nav nav-tabs">
    <li <?php if (Notification::get('upload')) { ?>class="active"<?php } ?>><a href="#upload" data-toggle="tab"><?php echo __('Upload photo', 'stock'); ?></a></li>
    <li <?php if (Notification::get('edit')) { ?>class="active"<?php } ?>><a href="#edit" data-toggle="tab"><?php echo __('Edit', 'stock'); ?></a></li>
    <li <?php if (Notification::get('resize')) { ?>class="active"<?php } ?>><a href="#resize" data-toggle="tab"><?php echo __('Resize', 'stock'); ?></a></li>
    <li <?php if (Notification::get('delete')) { ?>class="active"<?php } ?>><a href="#delete" data-toggle="tab"><?php echo __('Delete', 'stock'); ?></a></li>
</ul>

<div class="tab-content tab-page">
    <div class="tab-pane <?php if (Notification::get('upload')) { ?>active<?php } ?>" id="upload">
        <?php
        echo (
            Form::open(null, array('enctype' => 'multipart/form-data')).
            Form::hidden('csrf', Security::token()).
            Form::hidden('album_id', $album['id']).
            Form::input('file', null, array('type' => 'file', 'size' => '25')).Html::br().
            Form::submit('upload_file', __('Upload', 'stock'), array('class' => 'btn default btn-small')).
            Form::close()
        );
        ?>        
    </div>
    <div class="tab-pane <?php if (Notification::get('edit')) { ?>active<?php } ?>" id="edit">
        <?php 
        
        echo (
            '<form onSubmit="return stAlbumEditSave(this);" method="post">'.
            '<div style="overflow:hidden">'.
            Form::label('name', __('The album title', 'stock')).
            Form::input('name', $album['name'], array('style'=>'width:445px;')).
            '</div>'.
            '<div style="float:left; margin-right:20px;">'.
            Form::label('width_thumb', __('Width thumbnails (px)', 'stock')).
            Form::input('width_thumb', $album['w']).
            '</div><div style="float:left;">'.
            Form::label('height_thumb', __('Height thumbnails (px)', 'stock')).
            Form::input('height_thumb', $album['h']).
            '</div><br clear="both"/>'.
            '<div style="float:left; margin-right:20px;">'.
            Form::label('width_orig', __('Original width (px, max)', 'stock')).
            Form::input('width_orig', $album['wmax']).
            '</div><div style="float:left;">'.
            Form::label('height_orig', __('Original height (px, max)', 'stock')).
            Form::input('height_orig', $album['hmax']).
            '</div><br clear="both"/>'.
            '<div style="float:left; margin-right:20px;">'.
            Form::label('resize_way', __('Resize way', 'stock')).
            Form::select('resize_way', $resize_way, $album['resize']).Html::Br().
            '</div><div style="float:left; margin-top:2px;">'.
            Form::hidden('csrf', Security::token()).
            Form::hidden('album_id', $album['id']).
            Form::hidden('stock_submit_album_edit', true).
            Form::hidden('siteurl',Option::get('siteurl')).
            Form::label('submit_settings', __('&nbsp;')).
            Form::submit('submit_settings', __('Save', 'stock'), array('class' => 'btn')).
            '</div><br clear="both"/><div id="st-edit-result"></div>'.
            Form::close()
        );
        ?>  
    </div>
    <div class="tab-pane <?php if (Notification::get('resize')) { ?>active<?php } ?>" id="resize">
        <?php 
            echo __('Resize content', 'stock').Html::Br(2);
            echo Html::anchor(__('Resize start', 'stock'), '#',
           array('class' => 'btn btn-actions', 'onclick' => "return stResize(".$album['id'].", '".Option::get('siteurl')."');"));
        ?> 
        <div id="st_result"></div>
    </div>
    <div class="tab-pane <?php if (Notification::get('delete')) { ?>active<?php } ?>" id="delete">
        <?php echo __('sure album', 'stock');?><br/><br/>
        <a class="btn btn-actions" href="index.php?id=stock&delete_album=<?php echo $album['id'];?>&token=<?php echo Security::token();?>"><?php echo __('Delete album', 'stock');?></a>
        <br clear="both"/>
    </div>
</div>
<br/>
<table class="table table-bordered">
    <thead>
        <tr>
            <td><?php echo __('Photos', 'stock'); ?></td>
            <td><?php echo __('Shortcode', 'stock'); ?></td>
            <td width="30%"><?php echo __('Actions', 'stock'); ?></td>
        </tr>
    </thead>
    <tbody>
    <?php if (count($files) > 0) foreach ($files as $name) { ?>
    <tr>
        <td><a href="<?php echo $path_orig.$name;?>"><img src="<?php echo $path_thumb.$name;?>" style="max-width:100px; max-height:50px;" alt=""/></a></td>
        <td>{stock album="<?php echo $album['id'];?>" img="<?php echo $name; ?>"}</td>
        <td><?php echo Html::anchor(__('Delete', 'stock'), 'index.php?id=stock&album_id='.$album['id'].'&delete_img='.$name.'&token='.Security::token(), array('class' => 'btn btn-actions', 'onClick'=>'return confirmDelete(\''.__('sure', 'stock').'\')')); ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
