<h2><?php echo __('The default settings', 'stock');?></h2>
<ul class="breadcrumb">
    <li><a href="index.php?id=stock"><?php echo __('Stock', 'stock');?></a> <span class="divider">/</span></li>
    <li class="active"><?php echo __('Settings', 'stock');?></li>
</ul>
<?php       
echo (
    '<form onSubmit="return stSettingsSave(this);" method="post">'.
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
            Form::hidden('siteurl', Option::get('siteurl')).
            Form::hidden('stock_submit_settings', true).
            Form::label('submit_settings', __('&nbsp;')).
            Form::submit('submit_settings', __('Save', 'stock'), array('class' => 'btn')).
        '</div><br clear="both"/><div id="st-settings-result"></div>'.
    Form::close()
);
?>