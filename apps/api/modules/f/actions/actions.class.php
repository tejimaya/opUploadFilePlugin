<?php
class fActions extends opJsonApiActions
{
  public function executeUpload(sfWebRequest $request)
  {
    if ('1' === $request->getParameter('forceHtml'))
    {
      // workaround for some browsers
      $this->getResponse()->setContentType('text/html');
    }

    $filename = basename($_FILES['upfile']['name']);
    if (!$filename)
    {

      return $this->renderJSON(array('status' => 'error', 'message' => 'null file'));
    }

    $communityId = (int)$request->getParameter('community_id');
    if (1 <= (int)$communityId)
    {
      $community = Doctrine::getTable('Community')->find($communityId);
      if (!$community->isPrivilegeBelong($this->getUser()->getMember()->getId()))
      {

        return $this->renderJSON(array('status' => 'error', 'message' => 'you are not this community member.'));
      }
      $dirname = '/c'. $communityId;
    }
    else
    {
      $dirname = '/m'. $this->getUser()->getMember()->getId();
    }

    //validate $filepath
    if (!preg_match('/^\/[mc][0-9]+/', $dirname))
    {

      return $this->renderJSON(array('status' => 'error', 'message' => 'file path error. '.$dirname));
    }

    $f = new File();
    $f->setOriginalFilename($_FILES['upfile']['name']);
    $f->setType($_FILES['upfile']['type']);
    $f->setName($dirname.'/'.time().$_FILES['upfile']['name']);
    $f->setFilesize($_FILES['upfile']['size']);
    if ($stream = fopen($_FILES['upfile']['tmp_name'], 'r'))
    {
      $bin = new FileBin();
      $bin->setBin(stream_get_contents($stream));
      $f->setFileBin($bin);
      $f->save();
      $response = true;
    }
    else
    {
      //file open error
      $response = false;
    }
    if (true === $response)
    {

      return $this->renderJSON(array('status' => 'success', 'message' => 'file up success '.$response, 'file' => $f->toArray(false)));
    }
    else
    {

      return $this->renderJSON(array('status' => 'error', 'message' => 'file upload error'));
    }
  }

  public function executeList(sfWebRequest $request)
  {
    $path = $request->path;
    $fileList = Doctrine_Query::create()
      ->from('File f')
      ->where('f.name LIKE ?', $path.'/%')
      ->orderBy('f.updated_at DESC')
      ->fetchArray();

    return $this->renderJSON(array('status' => 'success', 'data' => $fileList));
  }

  public function executeFiles(sfWebRequest $request)
  {
    $path = $request->getParameter('path');
    if (!$path)
    {
      $path = '/m1/1340943961FILENAME.txt';
    }
    //TODO アクセス権限管理

    $file = Doctrine::getTable('File')->findOneByName($path);
    $filebin = $file->getFileBin();
    $data = $filebin->getBin();
    if (!$data)
    {

      return $this->renderJSON(array('status' => 'error', 'message' => 'file download error'));
    }

    $filename = substr($path, strpos($path, '/', 1));
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($data);
    $this->getResponse()->setHttpHeader('Content-Type', $type);
    $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename="'.$filename.'"');

    return $this->renderText($data);
  }

  public function executeDelete(sfWebRequest $request)
  {
    $path = $request->getParameter('path');
    $file = Doctrine::getTable('File')->findOneByName($path);
    $this->forward404Unless($file);
    $file->delete();

    return $this->renderJSON(array('status' => 'success'));
  }
}
