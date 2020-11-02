<?php

return function ($site) {

  $query   = get("q");

	$entries = page("database/items")->children()->listed()
	           ->add(page("database/entities")->children()->listed())
	           ->sortBy("title", "asc");

  if ($query) {
  	$entries = $entries->search($query);
  }

	$types = [];
	foreach ($entries as $e) {
	  $type = $e->entryType()->value();
	  if (!array_key_exists($type, $types)) {
	    $types[$type] = 1;
	  } else {
	    $types[$type]++;
	  }
	}

  return [
    "query"   => $query,
    "entries" => $entries,
    "types"		=> $types,
  ];

};