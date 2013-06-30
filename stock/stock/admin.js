function stResize(id, siteurl) {
    var st_result = $('#st_result');
    st_result.html('<img src="'+siteurl+'plugins/stock/stock/load.gif" width="16" height="16" alt=""/>');
    $.ajax({
        type: 'POST', 
        data: { album_id: id, st_resize: true }
    }).done(function(data) {
        st_result.html(data);
    });
    return false;
}

function stAlbumEditSave(f) {
    var st_result = $('#st-edit-result');
    st_result.html('<img src="'+f.siteurl.value+'plugins/stock/stock/load.gif" width="16" height="16" alt=""/>');
    $.ajax({
        type: 'POST', 
        data: $(f).serialize(),
        success: function(msg) {
            st_result.html(msg);
        }
    });
    return false;
}

function stSettingsSave(f) {
    var st_result = $('#st-settings-result');
    st_result.html('<img src="'+f.siteurl.value+'plugins/stock/stock/load.gif" width="16" height="16" alt=""/>');
    $.ajax({
        type: 'POST', 
        data: $(f).serialize(),
        success: function(msg) {
            st_result.html(msg);
        }
    });
    return false;
}