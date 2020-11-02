<?php

return [

	"debug" => true,

	"thumbs" => [
    "presets" => [
      "default" => ["width" => 120, "quality" => 80],
      "medium" => ["width" => 600, "quality" => 90]
    ]
	],

	"routes" => [

    [
      "pattern" => "/",
      "action"  => function () {
        return go("database");
       }
    ],

    [
      "pattern" => "/database",
      "action"  => function () {
        return go("database/explore");
       }
    ],


	],

];