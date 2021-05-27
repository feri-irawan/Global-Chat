<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');

date_default_timezone_set("Asia/Makassar");

// PATH JSON
$chatJSON = "res/json/chat.json";
$userJSON = "res/json/user.json";

// INSERT CHAT
if (isset($_POST["message"])) {

  $id = $_POST["id"];
  $username = $_POST["username"];
  $color = $_POST["color"];
  $date = $_POST["date"];
  $message = $_POST["message"];

  if ($message != null) {
    $chat = json_decode(file_get_contents($chatJSON), true);

    $chat_array = [
      "id" => $id,
      "username" => $username,
      "color" => $color,
      "message" => htmlspecialchars($message),
      "date" => $date,
      "timestamp" => date("h:i")
    ];


    $chat["chat"][] = $chat_array;
    file_put_contents($chatJSON, json_encode($chat, JSON_PRETTY_PRINT));
  }
}


// UPDATE CHAT
if (isset($_POST["update"])) {
  $update = $_POST["update"];

  // JIKA UPDATE CHAT
  if ($update == "chat") {

    $chat = json_decode(file_get_contents($chatJSON));
    if ($chat != null) {
      $chat = [
        "status_code" => 0,
        "status" => "success",
        "message" => "berhasil meangambil data chat",
        "items" => $chat
      ];

      header("Content-Type: application/json");
      echo json_encode($chat);

    } else {

      $chat = [
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
      echo json_encode($chat);

    }

  }

  // JIKA UPDATE USER
  else if ($update == "user") {}

}

// CLEAR CHAT
if (isset($_GET["clear-chat"])) {
  file_put_contents($chatJSON, "");
}