<?php
class ItemPage extends Page {
  	
  public function smartByline () {    
    if ($this->byline()->isNotEmpty()) {
      return $this->byline()->value();
    }
    $byline = ucfirst($this->itemType()->value());
    if ($this->author()->isNotEmpty()) {
      $authors = [];
      foreach ($this->author()->toPages() as $a) {
        $authors[] = $a->title();
      }
    	$byline .= " by ". implode(", ", $authors);
    }
    return $byline;
  }

}