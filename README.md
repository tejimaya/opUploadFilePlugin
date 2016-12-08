opUploadFilePlugin概要
======================
ファイルのアップロード・ダウンロード機能を追加します。  
アップロードしたファイルは、ファイルへのリンクを共有することでSNS内すべてのユーザーがダウンロードすることができます。  

PCのみの対応となっています。  
  
  
操作方法
----------------
<a href="https://pne.jp/upfile_usage.html" target="_blank">ファイルアップロード機能の使用方法</a>  
  
【注意事項】  
・ファイルのサイズが0の場合、アップロードはできるがダウンロードができません。  
・ファイルサイズ最大値の設定は以下の二カ所で行います。  
　　MySQLの設定ファイル(my.cnf)の「max allowed packet」  
　　PHPの設定ファイル(php.ini)の「upload_max_filesize」  
・設定されているファイルサイズの最大値を超えるファイルをアップロードできません。  
・ファイル名に以下の文字が含まれている場合、「-(ハイフン)」に変換します。  
　\, /, *, :, ?, &, ', ", >, <, undefined, |  
・ファイル名に4バイト文字等のDBで使用できない文字が含まれている場合、その文字は削除されます。  
  
  
インストール方法
----------------
アップロードアイコンを表示するためにopSkinThemePluginが必要です。  
https://github.com/tejimaya/opSkinThemePlugin を使用してください。  
  
  
**opSkinThemePluginインストール**  
    $ cd path/to/OpenPNE/plugins  
    $ git clone git://github.com/tejimaya/opSkinThemePlugin.git  
    $ cd opSkinThemePlugin  
    $ git checkout opSkinThemePlugin-1.0.13  
    $ cd path/to/OpenPNE  
    $ ./symfony cc  
    $ ./symfony plugin:publish-assets  
  
**opUploadFilePluginインストール**  
    $ cd path/to/OpenPNE/plugins  
    $ git clone git://github.com/tejimaya/opUploadFilePlugin.git
    $ cd opUploadFilePlugin  
    $ git checkout opUploadFilePlugin-0.9.1  
    $ cd path/to/OpenPNE  
    $ ./symfony cc  
    $ ./symfony plugin:publish-assets  
  
**ご使用中のOpenPNE3本体のバージョンによっては以下の処理が必要になることがあります。**  
    path/to/OpenPNE/lib/action/opJsonApiActions.class.php  
      30行目付近  
        $this->getResponse()->setContentType('application/json');  
      45行目付近  
        $this->getResponse()->setContentType('application/json');  
      上記2ヶ所を削除またはコメントアウトしてください。  
  
**プラグイン設定**  
・<a href="https://pne.jp/upfile_setting.html" target="_blank">ファイルアップロード機能の設定方法</a>  
・MySQLの設定ファイル(my.cnf)の「max allowed packet」とPHPの設定ファイル(php.ini)の「upload_max_filesize」にアップロードファイルの最大サイズを設定。  
  
動作環境
--------
OpnePNE3.8.2以上  
opSkinThemePluginに依存  
  
  
更新履歴
--------
 * 2012/11/20 作成  
 * 2013/01/16 更新  インストール手順の修正
 * 2014/08/18 更新  バージョン0.9.0リリース
 * 2016/12/08 更新  バージョン0.9.1リリース


追加予定機能
----------
 ・ファイルサイズチェック 　アップロード時にファイルサイズをチェックして画面に警告を表示する。  
 ・ファイル名の制限を強化 　javascriptでevalされても問題のないようにする。  


要望・フィードバック
----------

https://github.com/tejimaya/opUploadFilePlugin/issues