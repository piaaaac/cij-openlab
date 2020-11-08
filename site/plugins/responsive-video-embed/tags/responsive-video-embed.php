<?php

return [

  'attr' => array_merge(
    Kirby\Text\KirbyTag::$types['video']['attr'], [
      'ratio',
    ]
  ),

  'html' => function($tag) {

    $video =  Kirby\Text\KirbyTag::$types['video']['html'];
    $markup = $video($tag);

// return $markup;

    preg_match('/<iframe.*src=[\"\'](.*)[\"\'].*>/isU', $markup, $matches);
    $iframe = $matches[0];
    $src = $matches[1];

    $figureOpenTag = "<figure class='video'>";
    $figureCloseTag = "</figure>";
    $withoutFigure = substr($markup, strlen($figureOpenTag), -strlen($figureCloseTag));

    if(strpos($withoutFigure, "<figcaption")){
      $withoutFigcaption = substr($withoutFigure, 0, strpos($withoutFigure, "<figcaption"));
      // $figcaption = substr($withoutFigure, strpos($withoutFigure, "<figcaption"));
    } else {
      $withoutFigcaption = $withoutFigure;
      // $figcaption = "";
    }

    // return $withoutFigcaption;

    $figcaption = "";
    if(isset($tag->caption) && $tag->caption != ""){
      $figcaption = "<figcaption>". kti($tag->caption) ."</figcaption>";
    }

    $ratioStyle = "";
    if($tag->ratio){
      $ratioNums = explode("/", $tag->ratio);
      $ratioNum = floatval($ratioNums[0]) / floatval($ratioNums[1]);
      $ratioStyle = "style='padding-bottom: ". (100 / $ratioNum) ."%;'";
    }

    $html = "<figure class='responsive-video-embed'><div class='video-wrapper' ". $ratioStyle .">" . $withoutFigcaption . '</div>' . $figcaption . $figureCloseTag;

    return $html;
  }

];