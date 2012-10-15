<?php
class fComponents extends sfComponents
{
  public function executeFMenu()
  {
    $this->member = $this->getUser()->getMember();
  }
}
