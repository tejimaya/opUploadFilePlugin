<ul class="nav pull-right hide" id="dropbox-menu">
<li class="dropdown">
  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-folder-open icon-white"></i><b class="caret"></b></a>
  <ul class="dropdown-menu" id="dropbox-menuitems">
    <li><a href="#dropbox-uploadmodal" data-toggle="modal">アップロード</a></li>
    <li class="divider"></li>
  </ul>
</li>
</ul>

<script id="dropbox-menuitem-template" type="text/x-jquery-tmpl">
{{each data.contents}}
<li class="dropbox-item"><a class="shareLink" href="<?php echo url_for('dropbox/index') ?>?path={{html encodeURIComponent(path)}}">${path}</a></li>
{{/each}}
</script>

<script>
$('#dropbox-menu .dropdown-toggle').click(function(){
  $.getJSON(
    openpne.apiBase + 'dropbox/list',
    {
      apiKey: openpne.apiKey,
      path: '/m<?php echo $member->getId() ?>'
    },
    function(json) {
      if (json.status !== 'success') throw 'dropbox/list failed.';

      $('#dropbox-menuitems .dropbox-item').remove();

      var menuitem = $('#dropbox-menuitem-template').tmpl(json);
      $('#dropbox-menuitems').append(menuitem);
    }
  );
});

$(function(){
  $('#dropbox-menu').detach().insertAfter('.nav.pull-right:first').show();
});
</script>

<div id="dropbox-uploadmodal" class="modal hide" tabindex="-1">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 id="dropbox-uploadmodal-label">アップロード</h3>
  </div>
  <div class="modal-body" id="dropbox-uploadmodal-body1">
    <label>ファイル: <input name="upfile" type="file" id="dropbox-uploadmodal-upfile"></label>
  </div>
  <div class="modal-body hide" id="dropbox-uploadmodal-body2">
    URL: <a id="dropbox-upload-url"></a>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal">閉じる</button>
    <button class="btn btn-primary" id="dropbox-uploadsubmit">
      <span id="dropbox-uploadsubmit-text">実行</span>
      <?php echo op_image_tag('ajax-loader.gif', array('class' => 'hide', 'id' => 'dropbox-uploadsubmit-loading')) ?>
    </button>
  </div>
</div>

<script>
$('#dropbox-uploadsubmit').click(function(){
  $('#dropbox-uploadsubmit-text').hide();
  $('#dropbox-uploadsubmit-loading').show();

  $('#dropbox-uploadmodal .modal-body').upload(
    openpne.apiBase + 'dropbox/upload',
    {
      apiKey: openpne.apiKey,
      forceHtml: 1
    },
    function(json) {
      json = JSON.parse(json);

      $('#dropbox-uploadsubmit').hide();

      if (json.status !== 'success') throw 'dropbox/upload failed.';

      var url = '<?php echo url_for('dropbox/index', array('absolute' => true)) ?>?path=' +
        encodeURIComponent('/m<?php echo $member->getId() ?>/' + $('#dropbox-uploadmodal-upfile').val());

      $('#dropbox-upload-url').attr('href', url).text(url);

      $('#dropbox-uploadmodal-body1').hide();
      $('#dropbox-uploadmodal-body2').show();
    },
    'text'
  );
});
</script>
