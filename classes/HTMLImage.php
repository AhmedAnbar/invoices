<?php

class HTMLImage extends HTMLElement
{
	protected $tagname = 'img';
	
	public function __construct($content, $attributes = array())
	{
		parent::__construct($content, $attributes);
	}	
	
	public function getSource()
	{
		return 	'<' . $this->tagname . $this->getAttributesSource() . '/>';
	}
	
	public function getAttributesSource()
	{
		if (!array_key_exists('alt', $this->attributes))
		{
			$this->attributes['alt'] = 'This image needs alt text.';
		}
		return parent::getAttributesSource();
		
	}
}

?>