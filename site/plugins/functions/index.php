<?php
/**
 * Die and inspect variable
 */
function kill($var){
  die("<pre>". print_r($var, true));
}

function lipsum($times = 3){
  $lipsumSSS = "Lorem ipsum dolor sit amet";
  $lipsumSS = "Lorem ipsum dolor sit amet, consectetur adipiscing elit";
  $lipsumS = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac dui mollis, consequat enim at, tempus velit. Etiam feugiat a dolor id maximus. ";
  $lipsumM = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac dui mollis, consequat enim at, tempus velit. Etiam feugiat a dolor id maximus. Nunc cursus eros sit amet blandit fringilla. Duis vitae nisi fermentum, convallis erat at, malesuada elit. Aliquam tincidunt tincidunt.";
  $lipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac dui mollis, consequat enim at, tempus velit. Etiam feugiat a dolor id maximus. Nunc cursus eros sit amet blandit fringilla. Duis vitae nisi fermentum, convallis erat at, malesuada elit. Aliquam tincidunt tincidunt fringilla. Nulla malesuada enim a auctor ultrices. Aliquam consectetur elit ac dui cursus aliquet. Maecenas hendrerit porta tellus, sit amet interdum velit commodo sed. Vivamus tincidunt tellus pulvinar semper fermentum.";
  if($times == 1){ echo $lipsumSSS; }
  elseif($times == 2){ echo $lipsumSS; }
  elseif($times == 3){ echo $lipsumS; }
  elseif($times == 4){ echo $lipsumM; }
  elseif($times == 5){ echo $lipsum; }
  elseif($times == 6){ echo "$lipsum $lipsum"; }
  elseif($times == 7){ echo "$lipsum $lipsum $lipsum"; }
}

function spacer($n){
  echo '<div class="spacer" style="height: '. $n .'px;"></div>';
}

// -------------------------------------
// PROJECT SPECIFIC
// -------------------------------------

function pluralName ($str) {
  if ($str == "people") { return "people"; }
  return $str ."s";
}

function bylineWithPic ($page) {
  
  $pageTypes = [
    "collection"  => ["fieldName" => "curator",/*, "text" => "Collection curated by ",*/ "textEmpty" => ""],
    "article"     => ["fieldName" => "author",/*,  "text" => "Essay by ",*/ "textEmpty" => ""],
  ];
  $template = $page->template()->name();
  
  if (!array_key_exists($template, $pageTypes)) {
    kill("bylineWithPic() - not available for template ". $template ." (err. 09238472)");
  }

  $fieldName = $pageTypes[$template]["fieldName"];

  $entities = $page->$fieldName()->toPages();
  if ($entities && $entities->count() > 0) {

    // $text = $pageTypes[$template]["text"];
    $linksMarkup = [];
    $imagesMarkup = "";
    $n = $entities->count();
    $i = 0;
    foreach ($entities as $entity) {
      $linksMarkup[] = "<a class='color-red' onclick='a.openDetail(event, \"". $entity->id() ."\");'>". $entity->title() ."</a>";
      $imagesMarkup .= "<div class='image' style='background-image: url(\"". $entity->img()->toFile()->url() ."\");'></div>";
      $i++;
    }

    $text = "By ";
    switch ($n) {
      case 1:
        $text .= $linksMarkup[0];
        break;
      case 2:
        $text .= implode(" and ", $linksMarkup);
        break;
      case 3:
        $text .= $linksMarkup[0] .", ".$linksMarkup[1] ." and ". $linksMarkup[2];
        break;
    }

    return "
    <div class='byline-with-pic'>
      $imagesMarkup
      <div class='font-m'>". $text ."</div>
    </div>";

  } else {
  
    // $text = $pageTypes[$template]["textEmpty"];
    // return "<div class='byline-with-pic'><div>". $text ."</div></div>";
    return "";

  }
}