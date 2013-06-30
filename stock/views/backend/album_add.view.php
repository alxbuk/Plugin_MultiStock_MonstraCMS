<h2><?php echo __('Add album', 'stock');?></h2>
<ul class="breadcrumb">
    <li><a href="index.php?id=stock"><?php echo __('Stock', 'stock');?></a> <span class="divider">/</span></li>
    <li class="active"><?php echo __('Add album', 'stock');?></li>
</ul>
<?php       
echo (
    Form::open().
        '<div style="overflow:hidden">'.
            Form::label('name', __('The album title', 'stock')).
            Form::input('name', null, array('style'=>'width:445px;')).
        '</div>'.
        '<div style="float:left; margin-right:20px;">'.
            Form::label('width_thumb', __('Width thumbnails (px)', 'stock')).
            Form::input('width_thumb', Option::get('st_w')).
        '</div><div style="float:left;">'.
            Form::label('height_thumb', __('Height thumbnails (px)', 'stock')).
            Form::input('height_thumb', Option::get('st_h')).
        '</div><br clear="both"/>'.
        '<div style="float:left; margin-right:20px;">'.
            Form::label('width_orig', __('Original width (px, max)', 'stock')).
            Form::input('width_orig', Option::get('st_wmax')).
        '</div><div style="float:left;">'.
            Form::label('height_orig', __('Original height (px, max)', 'stock')).
            Form::input('height_orig', Option::get('st_hmax')).
        '</div><br clear="both"/>'.
        '<div style="float:left; margin-right:20px;">'.
            Form::label('resize_way', __('Resize way', 'stock')).
            Form::select('resize_way', $resize_way, Option::get('st_resize')).Html::Br().
        '</div><div style="float:left; margin-top:2px;">'.
            Form::hidden('csrf', Security::token()).
            Form::label('submit_album_add', __('&nbsp;')).
            Form::submit('submit_album_add', __('Save', 'stock'), array('class' => 'btn')).
        '</div><br clear="both"/>'.
    Form::close()
);
?>