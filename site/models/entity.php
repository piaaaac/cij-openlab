<?php
class EntityPage extends Page {
  	
  public function smartByline () {
		if ($this->byline()->isNotEmpty()) {
			return $this->byline()->value();
		}
    return ucfirst($this->entryType()->value());
  }

}