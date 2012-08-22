<?php

class opDropboxPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('op_action.pre_execute', array($this, 'appendJavascripts'));
  }

  public function appendJavascripts(sfEvent $event)
  {
    $event['actionInstance']->getResponse()->addJavascript('/opDropboxPlugin/js/bootstrap-modal.js', 'last');
    $event['actionInstance']->getResponse()->addJavascript('/opDropboxPlugin/js/filedialog.js', 'last');
    $event['actionInstance']->getResponse()->addJavascript('/opDropboxPlugin/js/jquery.upload.js', 'last');
  }
}
