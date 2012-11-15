function runTests(apiBase, apiKey) {
  QUnit.moduleStart(function(details) {
    $.ajax(apiBase + 'test/setup.json?force=1&target=opUploadFilePlugin', { async: false });
  });

  module('f/list');

  asyncTest('APIキーが指定されない場合にエラーを返す', 1, function() {
    $.getJSON(apiBase + 'f/list')
      .complete(function(jqXHR){
        equal(jqXHR.status, 401, 'statusCode');
        start();
      });
  });

  asyncTest('レスポンスのフォーマット', 10, function() {
    $.getJSON(apiBase + 'f/list',
    {
      apiKey: apiKey['1'],
    },
    function(data){
      equal(data.status, 'success', 'status');

      var file = data.data[0];
      equal(file.id, '1', 'data[0].id');
      equal(file.name, '/m1/1352977244hogehoge.txt', 'data[0].name');
      equal(file.type, 'text/plain', 'data[0].type');
      equal(file.filesize, '1000', 'data[0].filesize  ');
      equal(file.original_filename, 'hogehoge.txt', 'data[0].original_filename');
      equal(Date.parse(file.created_at), 1352977244, 'data[0].created_at');
      equal(Date.parse(file.updated_at), 1352977244, 'data[0].updated_at');
      equal(file.fname, '/m1/1352977244hogehoge', 'data[0].fname');
      equal(file.ext, '.txt', 'data[0].ext');

      start();
    });
  });
}

runTests(
  '../../api.php/',
  {
    '1': 'abcdef12345678900001', // member1
  }
);
