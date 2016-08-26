<?php
class component
{
	
	private $fileName;
	private $catName;
	
	
	
	public function setFileName($fileName)
	{
			$this->fileName = $fileName;
	}
	public function getFileName()
	{
			return $this->fileName;
	}
	
	
	public function setCatName($catName)
	{
			$this->catName = $catName;
	}
	public function getCatName()
	{
			return $this->catName;
	}
	
}
?>