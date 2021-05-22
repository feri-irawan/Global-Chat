<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');

date_default_timezone_set("Asia/Makassar");

$dbURL = "chat.json";
$chatStatusURL = "chat-status.json";


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


    // chat status
    $chatStatus = json_decode(file_get_contents($chatStatusURL));

    $chatStatus = [
      "update_status" => $chatStatus->update_status + 1
    ];

    file_put_contents($chatStatusURL, json_encode($chatStatus, JSON_PRETTY_PRINT));
  }
}








if (isset($_POST["update"])) {
  $update = $_POST["update"];

  $db = json_decode(file_get_contents($dbURL));

  if ($db != null) {
    $db = [
      "status_code" => 200,
      "status" => "success",
      "message" => "berhasil meangambil data chat",
      "items" => $db
    ];

    header("Content-Type: application/json");
    echo json_encode($db);

    /* foreach ($db->chat as $chat) {
      $id = $chat->id;
      $username = $chat->username;
      $color = $chat->color;
      $message = nl2br($chat->message);
      $date = $chat->date;
      $timestamp = $chat->timestamp;

      echo '
      <div class="chat-box-container chat-box-id-'.$id.'">
            <div class="chat">
              <div class="chat-box chat-box-left sayhaii-'.$id.'">
                <div class="chat-header">
                  <div class="chat-username fw-bold" style="color: '.$color.'">'.$username.'</div>
                  <div class="chat-time">
                    <span class="chat-date">'.$date.'</span>
                    <span class="chat-timestamp">'.$timestamp.'</span>
                  </div>
                </div>
                <div class="chat-body">'.$message.'</div>
              </div>
            </div>
      </div>
            ';
    } */

  } else {

    $db = [
      "status_code" => 500,
      "status" => "error",
      "message" => "chat masih kosong",
      "items" => [
        "chat" => [
          0 => [
            "id" => null,
            "username" => "SayHaii [bot]",
            "color" => "var(--bs-primary)",
            "date" => date("d/m/Y"),
            "timestamp" => date("H.i")
          ]
        ]
      ]
    ];

    header("Content-Type: application/json");
    echo json_encode($db);


    /* echo '
        <div class="chat-box-container">
          <div class="chat">
            <div class="chat-box chat-box-left">
              <div class="chat-header">
                <div class="chat-username fw-bold" style="color: var(--bs-primary)">SayHaii [bot]</div>
                <div class="chat-time">
                  <span class="chat-date">'.date("d/m/Y").'</span>
                  <span class="chat-timestamp">'.date("H.i").'</span>
                </div>
              </div>
              <div class="chat-body">
                <p>
                  <br>
                  <strong>Hello '.$_COOKIE["username"].', </strong><br>
                  Until now, no messages have been sent.  <br>
                  Be the first!
                </p>
              </div>
            </div>
          </div>
        </div>
          '; */

  }
}

// clear chat
if (isset($_GET["clear-chat"])) {
  file_put_contents($dbURL, "");
}