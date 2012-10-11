<style>
<!--

#dropbox-uploadmodal .modal-message {
  text-align: center;
  font-size: 120%;
  padding: 2em 0;
}

#dropbox-uploadmodal .modal-footer {
  text-align: center;
}

#dropbox-uploadmodal .btn {
  float: none;
  width: 30%;
}

-->
</style>

<ul class="nav pull-right" id="dropbox-menu" style="display: none">
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
<li class="dropbox-item">
  <a href="<?php echo $sf_request->getRelativeUrlRoot() ?>/f/show${path}" data-dropbox-path="${path}" data-dropbox-name="${name}">
    <button data-action="delete"><i class="icon-trash"></i></button>
    ${name}
  </a>
</li>
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

      $('button', menuitem).click(function(event){
        if (!confirm($(this.parentNode).data('dropboxName') + ' を削除しますか？')) return;
        $.getJSON(
          openpne.apiBase + 'dropbox/delete',
          {
            apiKey: openpne.apiKey,
            path: $(this.parentNode).data('dropboxPath')
          },
          function(json) {
            if (json.status === 'success')
              alert('削除しました');
            else
              alert('削除に失敗しました');
          }
        );
      });

      $('a', menuitem).click(function(event){
        if ($.inArray(event.target.tagName, ['BUTTON', 'I']) !== -1) event.preventDefault();
      });

      $('#dropbox-menuitems').append(menuitem);
    }
  );
});

$(function(){
  $('#dropbox-menu').detach().insertAfter('.nav.pull-right:first').show();
});
</script>

<div id="dropbox-uploadmodal" class="modal" tabindex="-1" style="display: none">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 id="dropbox-uploadmodal-label">アップロード</h3>
  </div>
  <div class="modal-body" id="dropbox-uploadmodal-body1">
    <p class="modal-message" id="dropbox-uploadmodal-message">ファイルをアップロードします</p>
    ファイル: <input name="upfile" type="file" id="dropbox-uploadmodal-upfile">
    <?php echo op_image_tag('ajax-loader.gif', array('class' => 'hide', 'id' => 'dropbox-uploadsubmit-loading')) ?>
  </div>
  <div class="modal-body hide" id="dropbox-uploadmodal-body2">
    <p class="modal-message" id="dropbox-uploadmodal-message">アップロードしました</p>
    <input type="input" id="dropbox-upload-url" />
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="dropbox-uploadsubmit">
      <span id="dropbox-uploadsubmit-text">アップロード</span>
    </button>
  </div>
</div>

<script>
$('#dropbox-uploadsubmit').click(function(){
  $('#dropbox-uploadmodal-message').text("アップロード中...");
  $('#dropbox-uploadsubmit').attr('disabled', 'disabled');
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

      var url = '<?php echo $sf_request->getUriPrefix().$sf_request->getRelativeUrlRoot() ?>/f/show' +
        '/m<?php echo $member->getId() ?>/' + $('#dropbox-uploadmodal-upfile').val();

      $('#dropbox-upload-url').val(url);

      $('#dropbox-uploadmodal-body1').hide();
      $('#dropbox-uploadmodal-body2').show();
    },
    'text'
  );
});
</script>
