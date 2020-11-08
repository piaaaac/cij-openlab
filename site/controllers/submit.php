<?php
return function($kirby, $pages, $page) {

  $alert = null;

  if($kirby->request()->is("POST") && get("submit")) {

    // check the honeypot
    if(empty(get("website")) === false) {
        go($page->url());
        exit;
    }

    $data = [
      "name"  => get("name"),
      "email" => get("email"),
      "title" => get("title"),
      "url"   => get("url"),
      "text"  => get("text"),
    ];

    $rules = [
      "name"  => ["required", "minLength" => 3],
      "email" => ["required", "email"],
      "title" => ["required", "minLength" => 3],
      "url"   => ["required", "url"],
      "text"  => ["required", "minLength" => 3, "maxLength" => 3000],
    ];

    $messages = [
      "name"  => "Please enter a valid name",
      "email" => "Please enter a valid email address",
      "title" => "Please enter a title",
      "url"   => "Please enter a valid url including http(s)://",
      "text"  => "Please enter a text between 3 and 3000 characters",
    ];

    // some of the data is invalid
    if($invalid = invalid($data, $rules, $messages)) {
      $alert = $invalid;

        // the data is fine, let"s send the email
    } else {
      try {
        $kirby->email([
          "template" => "email",
          "from"     => "openlab-submissions@tcij.org",
          "replyTo"  => $data["email"],
          "to"       => $page->formEmail()->value(),
          "subject"  => "CIJ Open Lab submission: ". esc($data["title"]),
          "data"     => [
            "title"  => esc($data["title"]),
            "url"    => esc($data["url"]),
            "text"   => esc($data["text"]),
            "sender" => esc($data["name"]),
            "email"  => esc($data["email"]),
          ]
        ]);

      } catch (Exception $error) {
        if(option("debug")):
          $alert["error"] = "The form could not be sent: <strong>" . $error->getMessage() . "</strong>";
        else:
          $alert["error"] = "The form could not be sent!";
        endif;
      }

      // no exception occurred, let"s send a success message
      if (empty($alert) === true) {
        $success = $page->formFeedback()->value() ?? "Thank you for your submission. We'll get back to you soon.";
        $data = [];
      }
    }
  }

  return [
    "alert"   => $alert,
    "data"    => $data ?? false,
    "success" => $success ?? false
  ];
};