<?php

/**
 * @param ratio (string) - optional - expressed as string such as 16/9
 * @param poster (string) - optional - file name for poster image uploaded in the panel
 * ?? maybe todo @param class (string) - optional - Custom class added to outer container

 >>> https://html5box.com/html5lightbox/

 */

return [

  'attr' => array_merge(
    Kirby\Text\KirbyTag::$types['video']['attr'], [
      'ratio',
      'poster',
      'bettercaption',
      'margin',
    ]
  ),

  'html' => function($tag) {

    $video =  Kirby\Text\KirbyTag::$types['video']['html'];
    $markup = $video($tag);
    $page = $tag->parent();
    $posterFilename = $tag->attr('poster');
    $id = "bettervideo-". Str::slug($tag->attr('bettervideo')) ."-". rand(0, 1000);

    // --- add attributes to iframe

    //
    //
    // TRY DOING IT PASSING attributes TO (VIDEO …)
    //
    //

    $iframeAttributes = "id='$id-iframe'";
    preg_match('/<iframe.*src=[\"\'](.*)[\"\'].*>/isU', $markup, $matches);
    $iframe = $matches[0];
    $src = $matches[1];
    if(strpos($src, "youtu")){ // if youtube, add origin to url
      // --- on what to include as origin parameter 
      //     read https://stackoverflow.com/a/20505337/2501713
      // $markup = str_replace($src, $src . "?origin=" . $page->url(), $markup);



      //  SEE https://developers.google.com/youtube/player_parameters#modestbranding


      $markup = str_replace($src, $src . "?origin=" . kirby()->site()->url(), $markup);
    }
    if(!strpos($iframe, "autoplay")){
      $iframeAttributes .= " allow='autoplay'";
    }
    $markup = str_replace("<iframe", "<iframe ". $iframeAttributes, $markup);

    $figureOpenTag = "<figure class='video'>";
    $figureCloseTag = "</figure>";
    $withoutFigure = substr($markup, strlen($figureOpenTag), -strlen($figureCloseTag));
    $posterMarkup = "";

    if($posterFile = $page->files()->findBy('filename', $posterFilename)) {
      $posterSrc = $posterFile->url();
      $posterMarkup = "<div class='poster-bg on'></div><div class='poster on' style='background-image: url(\"". $posterSrc ."\");' onclick='window.bettervideos[\"". $id ."\"].play();'></div>";
    }

    if(strpos($withoutFigure, "<figcaption")){
      $withoutFigcaption = substr($withoutFigure, 0, strpos($withoutFigure, "<figcaption"));
      // $figcaption = substr($withoutFigure, strpos($withoutFigure, "<figcaption"));
    } else {
      $withoutFigcaption = $withoutFigure;
      // $figcaption = "";
    }

    $figcaption = "";
    if(isset($tag->bettercaption) && $tag->bettercaption != ""){
      $figcaption = "<figcaption>". kti($tag->bettercaption) ."</figcaption>";
    }

    $ratioStyle = "";
    if($tag->ratio){
      $ratioNums = explode("/", $tag->ratio);
      $ratioNum = floatval($ratioNums[0]) / floatval($ratioNums[1]);
      $ratioStyle = "style='padding-bottom: ". (100 / $ratioNum) ."%;'";
    }

    $marginStyle = "";
    if($tag->margin){
      $marginStyle = "style='padding: 6%; background-color: ". $tag->margin ."'";
    }

    $html = "<figure class='bettervideo' id='". $id ."'><div class='margin' ". $marginStyle ."><div class='video-wrapper' ". $ratioStyle .">" . $posterMarkup . $withoutFigcaption . '</div></div>' . $figcaption . $figureCloseTag;

    return $html;
  }

];