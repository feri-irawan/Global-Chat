<?php
session_start();

if (isset($_POST["username"])) {
  $_SESSION["username"] = $_POST["username"];
  setcookie("username", $_POST["username"], time() + (7 * 24 * 60 * 60));
  header("location: index.php");
}

if (isset($_GET["logout"])) {
  session_destroy();
  setcookie("username", "", time()-3600);
  header("location: index.php");
}

if (isset($_COOKIE["username"]) != "" || isset($_SESSION["username"]) != "") {
  $loginStatus = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>SayHaii - Global chat sederhana</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" type="text/css" media="all" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>


  <?php if ($loginStatus == true): ?>
  <style>
    #chat-wrapper {
      overflow: hidden;
      height: calc(100vh - 7.5rem);
    }
    #chat-container {
      overflow-y: scroll;
      height: 100%;
      padding: 1rem .5rem;
    }
    #chat-form-container {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
    }
    /*
@media (min-width: 700px) {
  #chat-form-container {
    left: calc(10% + .7rem);
    right: calc(10% + .7rem);
  }
}
 */
    #chat-input {
      max-height: 5rem;
    }

    .chat {
      margin-left: 0.5rem;
      margin-bottom: 1rem;
      filter: drop-shadow(0px 2px 3px #00000020);
    }
    .chat-box {
      background: #fff;
      color: #444444;
      border-radius: 0 5px 5px 5px;
      font-size: 0.8rem;
      max-width: max-content;
      display: block;
      position: relative;
    }
    .chat-box::before {
      content: "";
      position: absolute;
      top: 0px;
      left: -0.7rem;
      border: 0.5rem solid #fff;
      border-bottom-color: transparent;
      border-left-color: transparent;
      z-index: -1;
    }
    .chat-box .chat-header {
      display: flex;
      justify-content: space-between;
    }
    .chat-header > * {
      margin: 0.3rem 0.5rem 0;
    }
    .chat-body {
      padding: 0 0.5rem 0.3rem;
    }
    .chat-time {
      font-size: 0.75rem;
    }
    .chat-date {
      display: none;
    }
    .chat:hover .chat-date {
      display: inline-block;
    }

    #btn-to-newchat {
      position: fixed;
      right: 20px;
      bottom: 5rem;
      border-radius: 20px;
      height: 2rem;
      width: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .loading-spin {
      animation: spinner1s infinite;
      animation-timing-function: linear;
    }
@keyframes spinner {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }
  </style>
  <?php endif;
  ?>
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
          <a class="nav-link" href="#">Donate</a>
          <a class="nav-link" href="?logout">Logout</a>
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
          <textarea name="chat" id="chat-input" rows="1" class="form-control" required></textarea>
        </div>
        <div class="ps-3 d-flex align-items-bottom">
          <button type="submit" id="btn-send" class="btn btn-primary">Send</button>
        </div>
      </form>
    </main>
  </section>

  <script>
    // membuat nila berbeda agar halaman melakuan request data pertamakali
    var statusOld = 0; statusNew = 1;

    // cek status lama, melakukan interval lebih lambat 3 detik dari statusNew
    // untuk membuat nilai statusOld berbeda dengan statusNew)
    var cekStatusLama = setInterval(() => {
      statusOld = statusChat()
    }, 5000)

    // cek status baru, melakukan interval lebih cepat 3 detik dari statusOld
    // untuk membuat nilai statusNew berbeda dengan statusOld)
    var cekStatusBaru = setInterval(() => {
      statusNew = statusChat()
    }, 2000)

    // cek kesamaan statusOld dengan statusNew setiap 1 detik
    setInterval(() => {

      if (statusOld == statusNew) {
        // jika status chat yang lama SUDAH SAMA dengan yang baru maka stop request chat.

        /**
        * Console:
        * konsol("Stop request: " + statusOld)
        */

      } else {

        // jika status chat yang lama TIDAK SAMA dengan yang baru maka lakukan request chat.

        /**
        * Console:
        * konsol("Melakukan request: " + statusNew)
        */

        // update chat karna statusOld tidak sama dengan statusNew
        getChat()
      }

    }, 1000)


    /**
    * =================
    * mengambil data statusChat
    * =================
    */
    function statusChat() {
      const path = "https://sayhaii.herokuapp.com/chat-status.json";
      var xhr = $.ajax({
        url: path,
        async: false
      });
      return xhr.responseJSON.update_status
    }


    // ketika #chat-form di submit
    $("#chat-form").submit(function (e) {

      // memasukan value #chat-input kedalam variable
      let chat = $("#chat-input").val();

      // mengganti teks "send" menjadi icon pada tombol
      let btnSend = $("#btn-send");
      btnSend.html(`
        <svg xmlns="http://www.w3.org/2000/svg" class="loading-spin" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
        </svg>
        `);

      // melakukan pengisiman message
      sendChat(chat);

      // jika form di submit halaman tidak melakukan refresh
      e.preventDefault();
    });


    /**
    * =================
    * fungsi untuk mengirim chat ke server
    * =================
    */
    function sendChat(chat) {

      // jika fungsi sendChat() digunakan maka lakukan "update" chat sekali
      getChat();

      // memasuka data ke dalam variable
      let username = Cookies.get("username");
      let date = new Date();
      let day = date.getDay();
      let month = date.getMonth();
      let year = date.getFullYear();
      date = day +"/"+ month +"/"+ year;
      let message = chat;

      // melakukan HttpRequest
      $.ajax({
        url: "proses.php",
        type: "post",
        data: {
          "username": username,
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
          konsol(x)
        }
      })
    }


    /**
    * =================
    * fungsi untuk mengambil data chat dan memperbaruhi isi #chat-container
    * ==================
    */
    function getChat() {
      $.ajax({
        url: "proses.php",
        type: "post",
        data: "update",
        success: function (res) {

          // jika berhasil mengambil data maka update isi #chat-container
          $("#chat-container").html(res);

          let btnSend = $("#btn-send");
          btnSend.html("Send")
        }
      })

      // jika salah satu .chat-box di klik maka tampilkan tanggal pengiriman
      $(".chat-box").click(function() {
        $(this).find(".chat-date").css("display", "inline-block")
      })
    }


    // mengatur tinggi form chat
    $("#chat-input").on("keyup", function () {
      let input = $(this);
      let chatWrapper = $("#chat-wrapper");
      let btnNewChat = $("#btn-to-newchat");

      let line = (input.val().match(/\n/g) || []).length;

      switch (line) {
        case 0:
          chatWrapper.css("height", "calc(100vh - 7.5rem)")
          input.css("height", "1rem")
          btnNewChat.css("bottom", "5rem");
          break;
        case 1:
          chatWrapper.css("height", "calc(100vh - 7.5rem)")
          input.css("height", "2rem")
          btnNewChat.css("bottom", "5rem");
          break;
        case 2:
          chatWrapper.css("height", "calc(100vh - 7.5rem - .5rem)")
          input.css("height", "3rem")
          btnNewChat.css("bottom", "calc(5rem + .5rem)");
          break;
        case 3:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 1.5rem)")
          input.css("height", "4rem")
          btnNewChat.css("bottom", "calc(5rem + 1.5rem)");
          break;
        case 4:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 2.5rem)")
          input.css("height", "5rem")
          btnNewChat.css("bottom", "calc(5rem + 2.5rem)");
          break;
        default:
          chatWrapper.css("height", "calc(100vh - 7.5rem - 2.5rem)")
          input.css("height", "5rem")
          btnNewChat.css("bottom", "calc(5rem + 2.5rem)");
        }
      });

      // tombol ke chat paling bawah
      $("#btn-to-newchat").click(function () {
        $("#chat").animate({
          scrollTop: $('#chat').get(0).scrollHeight
        }, 1000);
      });

      // fungsi console biasa agar lebih praktis
      function konsol(val) {
        return console.log(val)
      }
    </script>
    <?php endif; ?>
  </body>
</html>