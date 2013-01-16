opUploadFilePlugin概要
======================
ファイルのアップロード・ダウンロード機能を追加します。  
アップロードしたファイルはSNS内すべてのユーザーが閲覧・ダウンロードすることができます。  

PCのみの対応となっています。  


スクリーンショット
------
<a href="http://tejimaya.github.com/opUploadFilePlugin/images/fup_01.png" target=brank>
<img src="http://tejimaya.github.com/opUploadFilePlugin/images/fup_01.png" height=150/></a>
<a href="http://tejimaya.github.com/opUploadFilePlugin/images/fup_02.png" target=brank>
<img src="http://tejimaya.github.com/opUploadFilePlugin/images/fup_02.png" height=150/></a>
<a href="http://tejimaya.github.com/opUploadFilePlugin/images/fup_03.png" target=brank>
<img src="http://tejimaya.github.com/opUploadFilePlugin/images/fup_03.png" height=150/></a>


操作方法
----------------
・アップロード
　SNSログイン後、右上に表示されるアイコンをクリックし、アップロードリンクをクリック  
　表示されるダイアログにてアップロードするファイルを選択してアップロードボタンをクリック  
・ダウンロード  
　SNSログイン後、右上に表示されるアイコンをクリックするとアップロード済みファイルの一覧が表示されるのでファイル名をクリックする。  
・ダウンロード用リンクの取得  
　SNSログイン後、右上に表示されるアイコンをクリックするとアップロード済みファイルの一覧が表示されるのでファイル名を右クリックしリンク先URLを取得する。  
　アップロード完了時に表示されるダウンロード用リンクを取得しておく。  

【注意事項】  
・ファイルのサイズが0の場合、アップロードはできるがダウンロードができない。  
・ファイルサイズ最大値の設定は以下の二カ所で行う。  
　　MySQLの設定ファイル(my.cnf)の「max allowed packet」  
　　PHPの設定ファイル(php.ini)の「upload_max_filesize」  
・設定されているファイルサイズの最大値を超えるファイルをアップロードできません。  
・ファイル名に以下の文字が含まれている場合、「-(ハイフン)」に変換します。  
　\, /, *, :, ?, &, ', ", >, <, undefined, |  
・ファイル名に4バイト文字等のDBで使用できない文字が含まれている場合、その文字は削除されます。  


インストール方法
----------------
アップロードアイコンを表示するためにopSkinUnitedPluginが必要です。  
https://github.com/tejimaya/opSkinUnitedPlugin を使用してください。  
  
  
**opSkinUnitedPluginインストール**  
    cd path/to/OpenPNE/plugins  
    $ git clone git://github.com/tejimaya/opSkinUnitedPlugin.git  
    cd path/to/OpenPNE  
    $ ./symfony cc  
    $ ./symfony plugin:publish-assets  
  
**ファイルアップロードインストール**  
    cd path/to/OpenPNE/plugins  
    $ git clone git://github.com/tejimaya/opUploadFilePlugin.git  
    cd path/to/OpenPNE  
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
・管理画面->プラグイン設定->スキンプラグイン設定にてopSkinUnitedPluginを選択。  
・管理画面->上級者向け設定->JSON API使用設定にて「使用する」を選択。  
・管理画面->デザイン設定->ガジェット設定->サイドバナーガジェット設定->ガジェットを追加->FileUploadメニューを追加。  
・MySQLの設定ファイル(my.cnf)の「max allowed packet」とPHPの設定ファイル(php.ini)の「upload_max_filesize」にアップロードファイルの最大サイズを設定。  

動作環境
--------
OpnePNE3.8.2以上  
opSkinUnitedPluginに依存  


更新履歴
--------

 * 2012/11/20 作成  
 * 2013/01/16 更新  インストール手順の修正


追加予定機能
----------
 ・ファイルサイズチェック 　アップロード時にファイルサイズをチェックして画面に警告を表示する。  
 ・ファイル名の制限を強化 　javascriptでevalされても問題のないように。  


要望・フィードバック
----------

https://github.com/tejimaya/opUploadFilePlugin/issues