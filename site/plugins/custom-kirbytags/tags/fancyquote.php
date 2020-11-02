<?php

return [
  'attr' => ['small'], // --- expressed as float number obtained: W/H
  'html' => function($tag) {

    $text = $tag->attr('fancyquote');
    $small = $tag->small();

    $words = Str::split($text, " ");

    $min = 2;
    $max = 7;
    $every = 3;
    $times = rand($min, count($words)/$every);
    $times = $times > $max ? $max : $times;

		for ($time = 0; $time < $times; $time++) {
			$index = rand(0, count($words));
			$redacted = "";
			$n = rand(3, 12);
			for ($count = 0; $count < $n; $count++) {
				$redacted .= "█";
			}
			array_splice($words, $index, 0, $redacted);
		}

   //  foreach ($words as $i => $w) {
			// if (rand(1, 15) <= 1) {
			// 	$redacted = "";
			// 	$n = rand(5, 12);
			// 	for ($count = 0; $count < $n; $count++) {
			// 		$redacted .= "█";
			// 	}
			// 	array_splice($words, $i, 0, $redacted);
			// }
   //  }

    return "<blockquote><p>". implode(" ", $words) ."</p><p class='small'>". $small ."</p></blockquote>";
  }
];