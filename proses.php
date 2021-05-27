<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');

date_default_timezone_set("Asia/Makassar");

$dbURL = "res/json/chat.json";

if (isset($_POST["message"])) {

  $id = $_POST["id"];
  $username = $_POST["username"];
  $color = $_POST["color"];
  $date = $_POST["date"];
  $message = $_POST["message"];

  if ($message != null) {
    $db = json_decode(file_get_contents($dbURL), true);

    $chat_array = [
      "id" => $id,
      "username" => $username,
      "color" => $color,
      "message" => htmlspecialchars($message),
      "date" => $date,
      "timestamp" => date("h:i")
    ];


    $db["chat"][] = $chat_array;
    file_put_contents($dbURL, json_encode($db, JSON_PRETTY_PRINT));
  }
}



if (isset($_POST["update"])) {
  $update = $_POST["update"];

  $db = json_decode(file_get_contents($dbURL));

  if ($db != null) {
    $db = [
      "status_code" => 0,
      "status" => "success",
      "message" => "berhasil meangambil data chat",
      "items" => $db
    ];

    header("Content-Type: application/json");
    echo json_encode($db);

  } else {

    $db = [
      "status_code" => 1,
      "status" => "success",
      "message" => "chat masih kosong",
      "items" => [
        "chat" => [
          0 => [
            "id" => null,
            "username" => "SayHaii [bot]",
            "color" => "var(--bs-primary)",
            "date" => date("d/m/Y"),
            "timestamp" => date("H.i"),
            "message" => '<p>
                  <br>
                  <strong>Hello '.$_COOKIE["username"].', </strong><br>
                  Until now, no messages have been sent.  <br>
                  Be the first!
                </p>'
          ]
        ]
      ]
    ];

    header("Content-Type: application/json");
    echo json_encode($db);

  }
}

if (isset($_GET["clear-chat"])) {
  file_put_contents($dbURL, "");
}