<?php
date_default_timezone_set("Asia/Makassar");

$dbURL = "https://pixwebsite1998.000webhostapp.com/v2/global-chat/chat.json";

if (isset($_POST["message"])) {
  $username = $_POST["username"];
  $date = $_POST["date"];
  $message = $_POST["message"];

  if ($message != null) {
    $db = json_decode(file_get_contents($dbURL), true);

    $chat_array = [
        "username" => $username,
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
    
    foreach ($db->chat as $chat) {

      $username = $chat->username;
      $message = nl2br($chat->message);
      $date = $chat->date;
      $timestamp = $chat->timestamp;
      
      echo '<div class="chat">
              <div class="chat-box">
                <div class="chat-header">
                  <div class="chat-username fw-bold">'.$username.'</div>
                  <div class="chat-time">
                    <span class="chat-date">'.$date.'</span>
                    <span class="chat-timestamp">'.$timestamp.'</span>
                  </div>
                </div>
                <div class="chat-body">'.$message.'</div>
              </div>
            </div>
            ';
    }
  } else {
    echo '<div class="chat">
            <div class="chat-box">
              <div class="chat-header">
                <div class="chat-username fw-bold">SayHaii [bot]</div>
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
          ';
  }
}

// clear chat
if (isset($_GET["clear-chat"])) {
  file_put_contents($dbURL, "");
}