<?php

class opDropboxImportFrom2Task extends sfTask
{
  protected function configure()
  {
    $this->namespace        = 'opDropbox';
    $this->name             = 'import-from-2';
    $this->briefDescription = 'Install Command for "opTimelinePlugin".';
 
    $this->detailedDescription = <<<EOF
Use this command to install "opTimelinePlugin".
EOF;
  }
 
  protected function execute($arguments = array(), $options = array())
  {
    $this->conn = Doctrine_Manager::connection();

    $this->conn->beginTransaction();
    try
    {
      $this->doImport();

      $this->conn->commit();
    }
    catch (Exception $e)
    {
      $this->conn->rollback();

      throw $e;
    }
  }
}
