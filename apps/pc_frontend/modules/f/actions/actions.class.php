<?php

/**
 * UploadFile actions.
 *
 * @package    OpenPNE
 * @author     Your name here
 */
class fActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfWebRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    // for apiKey check
    $memberId = $this->getUser()->getMember();
    $reqFileName = $request->getParameter('filename');
    $separates = explode('.', $reqFileName);
    $cnt = count($separates);
    $fileId = '';
    $ext = '';
    if (1 == $cnt)
    {
      $fileId = $reqFileName;
    }
    else
    {
      $fileId = join('', array_slice($separates, 0, $cnt - 1));
      $ext = '.'.$separates[$cnt - 1];
    }
    $file = Doctrine::getTable('File')->find($fileId);
    $this->forward404Unless($file);
    $filebin = $file->getFileBin();
    $data = $filebin->getBin();
    $filename = $file->getName();

    $filename = substr($filename, strpos($filename, "/", 1));

    opToolkit::fileDownload($filename, $data);
  }
}
