// membuat nila berbeda agar halaman melakuan request data pertamakali
var statusOld = 0; statusNew = statusChat();

// cek status lama, melakukan interval lebih lambat dari statusNew
// untuk membuat nilai statusOld berbeda dengan statusNew)
var cekStatusLama = setInterval(() => {
  statusOld = statusChat();
}, 1000);

// cek status baru, melakukan interval lebih cepat dari statusOld
// untuk membuat nilai statusNew berbeda dengan statusOld)
var cekStatusBaru = setInterval(() => {
  statusNew = statusChat();
}, 500);

// cek kesamaan statusOld dengan statusNew setiap 0.2 detik
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
    //getChat();
  }

}, 200);


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
  return xhr.responseJSON.update_status;
}


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
  //getChat();

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
    url: "proses.php",
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

setInterval(function() {
  getChat()
}, 1000)


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

      var btnSend = $("#btn-send");
      btnSend.html("Send");

      konsol(res)

      setTimeout(
        function() {
          Cookies.set("chat", res.items.chat.length, {
            expires: 7, path: ''
          });
        }, 10);

      if (res.items.chat.length != Cookies.get("chat")) {

        konsol("Belum sama")
        var container = $("#chat-container");
        var chat = res.items.chat[0];
        var i,
        lastChat;

        if (res.items.chat.length > 0) {
          lastChat = 1;
        } else {
          lastChat = 0;
        }

        container.html("")

        for (i = 0; i < (res.items.chat.length - lastChat); i++) {

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
            `)
        }

        for (i = 0; i < res.items.chat.length; i++) {
          chat = res.items.chat[i];
        }

        $("#chat-container").append(`
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
          `)

      } else {
        konsol("sudah sama")
      }


      /*
      // jika berhasil mengambil data maka update isi #chat-container
      $("#chat-container").html(res);

      $(".chat-box-id-" + Cookies.get("sayhaii_id")).css("justify-content", "flex-end");
      $(".sayhaii-"+ Cookies.get("sayhaii_id")).removeClass("chat-box-left").addClass("chat-box-right");
      $("#chat-audio").get(0).play()

      var btnSend = $("#btn-send");
      btnSend.html("Send");

      scrollToBottom()
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