<?php
session_start();

if (isset($_POST["username"])) {
  $_SESSION["username"] = $_POST["username"];
  setcookie("username", $_POST["username"], time() + (7 * 24 * 60 * 60));
  setcookie("sayhaii_id", uniqid(""), time() + (7 * 24 * 60 * 60));

  header("location: https://".$_SERVER["HTTP_HOST"]);
}

if (isset($_GET["logout"])) {
  session_destroy();
  setcookie("username", "", time()-3600);
  setcookie("sayhaii_id", "", time()-3600);
  header("location: https://".$_SERVER["HTTP_HOST"]);
}

if (isset($_COOKIE["username"]) != "" || isset($_SESSION["username"]) != "") {
  $loginStatus = true;
}
?>

<!DOCTYPE html>
<html lang="en" translate="no">
<head>
  <!--
           * =============================
           * Do not copy without permission
           * Made by Feri Irawan, Indonesia
           * Copyright 2021
           * All rights reserved
           * =============================
          -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="google" content="notranslate" />
  <meta name="description" content="Made with&heart; by Feri Irawan, Indonesia" />
  <title>SayHaii - Global chat sederhana</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" type="text/css" media="all" />
  <?php if ($loginStatus == true): ?>
  <link rel="stylesheet" href="res/style.css" type="text/css" media="all" />
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">SayHaii</a>

      <?php if ($loginStatus == true): ?>
      <button class="btn text-white dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <?=$_COOKIE["username"] ?>
      </button>
      <div class="collapse navbar-collapse" id="navbarDropdown">
        <div class="navbar-nav">
          <a class="nav-link" href="https://saweria.co/feriirawans">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12.164 7.165c-1.15.191-1.702 1.233-1.231 2.328.498 1.155 1.921 1.895 3.094 1.603 1.039-.257 1.519-1.252 1.069-2.295-.471-1.095-1.784-1.827-2.932-1.636zm1.484 2.998l.104.229-.219.045-.097-.219c-.226.041-.482.035-.719-.027l-.065-.387c.195.03.438.058.623.02l.125-.041c.221-.109.152-.387-.176-.453-.245-.054-.893-.014-1.135-.552-.136-.304-.035-.621.356-.766l-.108-.239.217-.045.104.229c.159-.026.345-.036.563-.017l.087.383c-.17-.021-.353-.041-.512-.008l-.06.016c-.309.082-.21.375.064.446.453.105.994.139 1.208.612.173.385-.028.648-.36.774zm10.312 1.057l-3.766-8.22c-6.178 4.004-13.007-.318-17.951 4.454l3.765 8.22c5.298-4.492 12.519-.238 17.952-4.454zm-2.803-1.852c-.375.521-.653 1.117-.819 1.741-3.593 1.094-7.891-.201-12.018 1.241-.667-.354-1.503-.576-2.189-.556l-1.135-2.487c.432-.525.772-1.325.918-2.094 3.399-1.226 7.652.155 12.198-1.401.521.346 1.13.597 1.73.721l1.315 2.835zm2.843 5.642c-6.857 3.941-12.399-1.424-19.5 5.99l-4.5-9.97 1.402-1.463 3.807 8.406-.002.007c7.445-5.595 11.195-1.176 18.109-4.563.294.648.565 1.332.684 1.593z" /></svg>
            Donate
          </a>
          <a class="nav-link" href="?logout">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
              <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
            </svg>
            Logout
          </a>
        </div>
      </div>
      <?php endif; ?>

    </div>
  </nav>

  <?php if ($loginStatus != true): ?>
  <section class="container p-3">
    <h5>Hi, welcome</h5>
    <p class="text-muted">
      Simple global chat.
    </p>
    <p>
      Please enter your username to start chatting!
    </p>


    <form action="" method="post">
      <div class="input-group">
        <input type="text" name="username" class="form-control" placeholder="Your username">
        <button class="btn btn-primary" type="submit">Next</button>
      </div>
    </form>
  </section>
  <?php endif; ?>

  <?php if ($loginStatus == true): ?>
  <section id="chat-wrapper" class="container bg-white">
    <main id="chat-container">
    </main>
  </section>
  <section class="container">
    <main id="chat-form-container">
      <div id="btn-to-newchat" class="shadow text-white bg-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
          <path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
        </svg>
      </div>
      <form id="chat-form" class="d-flex p-3">
        <div class="w-100">
          <textarea name="chat" id="chat-input" rows="1" class="form-control" placeholder="Type a message" required></textarea>
        </div>
        <div class="ps-3 d-flex align-items-bottom">
          <button type="submit" id="btn-send" class="btn btn-primary">Send</button>
        </div>
      </form>
    </main>
  </section>
  <audio id="chat-audio" src="res/popup.mp3?raw=true"></audio>

  <!-- <script src="res/sayhaii.js" type="text/javascript" charset="utf-8"></script> -->

  <script>
    getChat()

    $(document).ready(function() {
      setInterval(function() {
        getChat();
      }, 1000);
    });

    // ketika #chat-form di submit
    $("#chat-form").submit(function (e) {

      // memasukan value #chat-input kedalam variable
      var chat = $("#chat-input").val();

      // mengganti teks "send" menjadi icon pada tombol
      var btnSend = $("#btn-send");
      btnSend.html(`
        <svg xmlns="http://www.w3.org/2000/svg" class="loading-spin" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
        </svg>
        `);

      // melakukan pengiriman message
      sendChat(chat);

      // jika form di submit halaman tidak melakukan refresh
      e.preventDefault();
    });


    // membuat warna acak
    const colorArray = [
      "#ff002b",
      "#ffe900",
      "#17c426",
      "#00cbfd",
      "#ed00ff",
      "#ff7e00",
      "#c200ff"
    ];

    var usernameColor = randArray(colorArray);


    /**
    * =================
    * fungsi untuk mengirim chat ke server
    * =================
    */
    function sendChat(chat) {

      // jika fungsi sendChat() digunakan maka lakukan "update" chat sekali
      getChat();

      // memasuka data ke dalam variable
      var id = Cookies.get("sayhaii_id");
      var username = Cookies.get("username");
      var date = new Date();
      var day = date.getDay();
      var month = date.getMonth();
      var year = date.getFullYear();
      date = day +"/"+ month +"/"+ year;
      var message = chat;

      // melakukan HttpRequest
      $.ajax({
        url: "https://sayhaii.herokuapp.com/proses",
        type: "post",
        data: {
          "id": id,
          "username": username,
          "color": usernameColor,
          "date": "1/5/2020",
          "message": message
        },
        success: function () {

          // lakukan getChat() jika message berhasil dikirim
          getChat();

          // mengosongkan value dari #chat-input
          $("#chat-input").val("");
        },
        error: function (x, s, e) {
          konsol(x);
        }
      });
    }


    /**
    * =================
    * fungsi untuk mengambil data chat dan memperbaruhi isi #chat-container
    * ==================
    */
    function getChat() {
      var container = $("#chat-container");
      var btnSend = $("#btn-send");

      $.ajax({
        url: "https://sayhaii.herokuapp.com/proses",
        type: "post",
        data: "update",
        success: function (res) {
          konsol(res);

          btnSend.html("Send");

          setTimeout(
            function() {
              Cookies.set("chat", res.items.chat.length, {
                expires: 7, path: ''
              });
            }, 10);


          if (res.items.chat.length != Cookies.get("chat")) {
            konsol("Belum sama");
            var chat = res.items.chat[0];
            var i;

            container.html("");

            for (i = 0; i < (res.items.chat.length - 1); i++) {
              chat = res.items.chat[i];
              container.append(`
                <div class="chat-box-container chat-box-id-`+chat.id+`">
                <div class="chat">
                <div class="chat-box chat-box-left sayhaii-`+chat.id+`">
                <div class="chat-header">
                <div class="chat-username fw-bold" style="color: `+chat.color+`">`+chat.username+`</div>
                <div class="chat-time">
                <span class="chat-date">`+chat.date+`</span>
                <span class="chat-timestamp">`+chat.timestamp+`</span>
                </div>
                </div>
                <div class="chat-body">`+chat.message+`</div>
                </div>
                </div>
                </div>
                `);
            }

            // mengambil chat dengan index terakhir
            for (i = 0; i < res.items.chat.length; i++) {
              chat = res.items.chat[i];
            }

            // kemudian menambahkan isi #chat-container diakhir
            container.append(`
              <div class="chat-box-container chat-box-id-`+chat.id+`">
              <div class="chat">
              <div class="chat-box chat-box-left sayhaii-`+chat.id+`">
              <div class="chat-header">
              <div class="chat-username fw-bold" style="color: `+chat.color+`">`+chat.username+`</div>
              <div class="chat-time">
              <span class="chat-date">`+chat.date+`</span>
              <span class="chat-timestamp">`+chat.timestamp+`</span>
              </div>
              </div>
              <div class="chat-body">`+chat.message+`</div>
              </div>
              </div>
              </div>
              `);

            $(".chat-box-id-" + Cookies.get("sayhaii_id")).css("justify-content", "flex-end");
            $(".sayhaii-"+ Cookies.get("sayhaii_id")).removeClass("chat-box-left").addClass("chat-box-right");
            $("#chat-audio").get(0).play()
            scrollToBottom();
          } else {
            konsol("sudah sama");
          }

          if (res.items.chat.length == 1) {
            var chat = res.items.chat[0];
            container.html(`
              <div class="chat-box-container chat-box-id-`+chat.id+`">
              <div class="chat">
              <div class="chat-box chat-box-left sayhaii-`+chat.id+`">
              <div class="chat-header">
              <div class="chat-username fw-bold" style="color: `+chat.color+`">`+chat.username+`</div>
              <div class="chat-time">
              <span class="chat-date">`+chat.date+`</span>
              <span class="chat-timestamp">`+chat.timestamp+`</span>
              </div>
              </div>
              <div class="chat-body">`+chat.message+`</div>
              </div>
              </div>
              </div>
              `);
            $(".chat-box-id-" + Cookies.get("sayhaii_id")).css("justify-content", "flex-end");
            $(".sayhaii-"+ Cookies.get("sayhaii_id")).removeClass("chat-box-left").addClass("chat-box-right");
          }


          /*
      // jika berhasil mengambil data maka update isi #chat-container
      $("#chat-container").html(res);

      var btnSend = $("#btn-send");
      btnSend.html("Send");

      // jika salah satu .chat-box di klik maka tampilkan tanggal pengiriman
      $(".chat-box").click(function() {
        $(this).find(".chat-date").css("display", "inline-block");
      });
      */

        }
      });
    }



    // mengatur tinggi form chat
    $("#chat-input").on("keyup", function () {
      var input = $(this);
      var chatWrapper = $("#chat-wrapper");
      var btnNewChat = $("#btn-to-newchat");

      var line = (input.val().match(/\n/g) || []).length;

      switch (line) {
        case 0:
          chatWrapper.css("height", "calc(100vh - 7.5rem)");
          input.css("height", "1rem");
          btnNewChat.css("bottom", "5rem");
          break;
        case 1:
          chatWrapper.css("height", "calc(100vh - 7.5rem)");
          input.css("height", "2rem");
          btnNewChat.css("bottom", "5rem");
          break;
        case 2:
          chatWrapper.css("height", "calc(100vh - 7.5rem - .5rem)");
          input.css("height", "3rem");
          btnNewChat.css("bottom", "calc(5rem + .5rem)");
          break;
        case 3:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 1.5rem)");
          input.css("height", "4rem");
          btnNewChat.css("bottom", "calc(5rem + 1.5rem)");
          break;
        case 4:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 2.5rem)");
          input.css("height", "5rem");
          btnNewChat.css("bottom", "calc(5rem + 2.5rem)");
          break;
        default:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 2.5rem)");
          input.css("height", "5rem");
          btnNewChat.css("bottom", "calc(5rem + 2.5rem)");
        }
      });

      // scroll ke chat paling bawah
      $("#btn-to-newchat").click(function () {
        scrollToBottom();
      });

      function scrollToBottom() {
        $("#chat-container").animate({
          scrollTop: $('#chat-container').get(0).scrollHeight
        },
          1000);
      }


      /**
      * =================
      * fungsi acal array
      * =================
      */
      function randArray(arr) {
        // membuat index acak
        const indexAcak = Math.floor(Math.random() * arr.length);

        // menggambil array acak
        const item = arr[indexAcak];
        return item;
      }

      // fungsi console biasa agar lebih praktis
      function konsol(val) {
        return console.log(val);
      }
    </script>
    <?php endif; ?>
  </body>
</html>