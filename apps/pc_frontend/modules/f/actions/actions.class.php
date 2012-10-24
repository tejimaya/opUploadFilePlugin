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
    $path = sprintf('/%s/%s', $request->getParameter('directory'), $request->getParameter('filename'));
    $file = Doctrine::getTable('File')->findOneByName($path);
    $this->forward404Unless($file);
    $filebin = $file->getFileBin();
    $data = $filebin->getBin();

    if (!$data)
    {

      return $this->renderJSON(array('status' => 'error', 'message' => 'file download error'));
    }

    $filename = substr($path, strpos($path, "/", 1));
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($data);
    $this->getResponse()->setHttpHeader('Content-Type', $type);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    return $this->renderText($data);
  }
}
