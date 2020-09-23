<?php
class ItemPage extends Page {
  public function smartByline () {
  	
    
    if ($this->byline()->isNotEmpty()) {
      return $this->byline()->value();
    }

    $byline = $this->itemType()->toUpper();

    if ($this->author()->isNotEmpty()) {
    	$byline .= " by ". $this->author()->toPage()->title();
    }

    return $byline;
  }
}