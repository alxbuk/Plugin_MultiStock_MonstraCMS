<h2><?php echo __('Stock', 'stock');?></h2>

<a class="btn btn-small" href="index.php?id=stock&action=addalbum"><?php echo __('Add album', 'stock');?></a> 
<a class="btn btn-small" href="index.php?id=stock&action=settings"><?php echo __('Settings', 'stock');?></a>
<br clear="both"/><br/>

<table class="table table-bordered">
    <thead>
        <tr>
            <td><?php echo __('Albums', 'stock'); ?></td>
            <td><?php echo __('Shortcode', 'stock'); ?></td>
            <td><?php echo __('Size', 'stock'); ?></td>
            <td width="30%"><?php echo __('Actions', 'stock'); ?></td>
        </tr>
    </thead>
    <tbody>
    <?php if (count($records) > 0) foreach ($records as $row) { ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td>{stock album="<?php echo $row['id']; ?>"}</td>
        <td><?php echo $row['w'].'x'.$row['h']; ?></td>        
        <td><?php echo Html::anchor(__('Show', 'stock'), 'index.php?id=stock&album_id='.$row['id'], array('class' => 'btn btn-actions')); ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>

<h3>ШортКоды для плагина МультиСток</h3>

<div class="well well-small"><h4>Галерея</h4>
Шорткод выдается в админке плагина<br/><br/>
<code>{stock album="1"}</code>
</div>

<div class="well well-small"><h4>Одиночная картинка</h4>
Шорткод выдается в админке плагина<br/>
В <strong>title</strong> указываем текст ссылки, этот же текст будет описанием<br/><br/>
<code>{stock album="1" img="2ivQXNdval.jpg"}</code> - Без подписи<br/>
<code>{stock album="1" img="2ivQXNdval.jpg" title="Проверка Подписи"}</code> - С  подписью
</div>

<div class="well well-small"><h4>YouTube ролик в виде ссылки</h4>
Вставляем ролик через код<br/>
http://www.youtube.com/watch?v=<strong>UjQ7NoyDLO4</strong> - это код видео<br/>
В <strong>code</strong> указываем код видео YouTube<br/>
В <strong>title</strong> указываем текст ссылки, этот же текст будет описанием<br/><br/>
<code>{stock_ytb_link code="UjQ7NoyDLO4" title="Monstra CMS - Установка и обзор"}</code>
</div>

<div class="well well-small"><h4>YouTube ролик с эскизом</h4>
Вставляем ролик через код<br/>
http://www.youtube.com/watch?v=<strong>UjQ7NoyDLO4</strong> - это код видео<br/>
В <strong>code</strong> указываем код видео YouTube<br/>
В <strong>title</strong> указываем текст c описанием<br/><br/>
Эскиз берется автоматически на основании кода ролика. Зависит от YouTube.<br/>
Пример - http://i4.ytimg.com/vi/UjQ7NoyDLO4/default.jpg<br/><br/>
<code>{stock_ytb_thumb code="JRlDEj-cv5w" title="Monstra CMS - Установка и обзор"}</code>
</div>


<div class="well well-small"><h4>Vimeo ролик в виде ссылки</h4>
Вставляем ролик через код<br/>
https://vimeo.com/<strong>66472808</strong> - это код видео<br />
В <strong>code</strong> указываем код видео Vimeo<br/>
В <strong>title</strong> указываем текст ссылки, этот же текст будет описанием<br/><br/>
<code>{stock_vmo_link code="66472808" title="Monstra CMS - Установка и обзор"}</code>
</div>

<div class="well well-small"><h4>Vimeo ролик с эскизом</h4>
Вставляем ролик через код<br/>
https://vimeo.com/<strong>66472808</strong> - это код видео<br />
В <strong>code</strong> указываем код видео Vimeo<br/>
В <strong>thumb</strong> указываем ссылку на эских, ищите через сайт Vimeo<br/>
В <strong>title</strong> указываем текст c описанием<br/><br/>
<code>{stock_vmo_thumb code="66472808" title="PhotoStock SB" thumb="http://secure-b.vimeocdn.com/ts/437/900/437900298_295.jpg"}</code>
</div>

<div class="well well-small"><h4>iFrame веб страница</h4>
В <strong>url</strong> указываем ссылку на сайт<br/>
В <strong>title</strong> указываем текст ссылки, этот же текст будет описанием<br/><br/>
<code>{stock_frame url="http://3255.ru" title="Компьютерная помощь в Омске"}</code>
</div>

<div class="well well-small"><h4>Модальное окно с контеном</h4>
В <strong>div</strong> указываем id на соответствуйющий div блок<br/>
В <strong>title</strong> указываем текст ссылки, этот же текст будет описанием<br/><br/>
<code>{stock_modal div="test" title="Проверка"}</code><br/><br/>

После добавления шорт кода добавляем сам div блок, только display block, заменить на none<br/><br/>
<code>&lt;div style="display:block"&gt;</code><br/>
<code>&lt;div id='test'&gt;Здесь контент&lt;/div&gt;</code><br/>
<code>&lt;/div&gt;</code><br/>
</div>