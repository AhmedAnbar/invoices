<?php

class HTMLParagraph extends HTMLElement 
{
	protected $tagname = 'span';
	
	public function __construct($content, $attributes = array())
	{
		parent::__construct($content, $attributes);
	}	
}

?>