<?php

class HTMLElement
{
	protected $content;
	protected $tagname;
	protected $attributes;
	
	public function __construct($content, $attributes = array())
	{
		$this->content = $content;
		$this->attributes = $attributes;
	}
	
	
	
	public function getAttributesSource()
	{
		$attributes = '';
		
		if (count($this->attributes))
		{
			foreach ($this->attributes as $attname => $attval)
			{
				$attributes .= ' ' . $attname . '="' . $attval . '"';
			}
		}
		return $attributes;
	}
	
	public function getSource()
	{
		return '<' . $this->tagname . $this->getAttributesSource() . '>' . $this->content . '</' . $this->tagname . '>';
	}
	
	public function __toString()
	{
		return $this->getSource();
	}
}

?>