<?php

class opUploadFilePluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->dispatcher->connect('op_action.pre_execute', array($this, 'appendJavascripts'));
  }

  public function appendJavascripts(sfEvent $event)
  {
    $context = sfContext::getInstance();
    if ('pc_frontend' == $context->getConfiguration()->getApplication())
    {
      $event['actionInstance']->getResponse()->addJavascript('/opUploadFilePlugin/js/bootstrap-modal.js', 'last');
      $event['actionInstance']->getResponse()->addJavascript('/opUploadFilePlugin/js/jquery.upload.js', 'last');
    }
  }
}
