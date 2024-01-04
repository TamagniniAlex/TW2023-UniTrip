$(document).ready(function () {
  var focusOn = window.location.pathname.split('/').pop().split('.')[0];
  html = `
  <nav class="navbar bg-light fixed-bottom border-top border-2">
    <div class="container">
      <div class="d-flex justify-content-around w-100 fs-3">
        <a href="feed.html" class="text-center text-` + (focusOn == "feed" ? "dark" : "muted") + `"><em  class="fa fa-home"></em></a>
        <a href="search.html" class="text-center text-` + (focusOn == "search" ? "dark" : "muted") + `"><em  class="fa fa-search"></em></a>
        <a href="addPost.html" class="text-center text-` + (focusOn == "addPost" ? "dark" : "muted") + `"><em  class="fa fa-plus"></em></a>
        <a href="notify.html" class="text-center text-` + (focusOn == "notify" ? "dark" : "muted") + `"><em  class="position-relative fa fa-bell-o">
          <span id = "notifications" class="position-absolute top-20 start-100 translate-middle badge rounded-pill ">
          </span></em>
        </a>
        <a href="messages.html" class="text-center text-` + (focusOn == "messages" ? "dark" : "muted") + `"><em  class="fa fa-envelope-o"></em></a>
      </div>
    </div>
  </nav>`
  $("#navbar").append(html);

  setInterval(function () {
    $.ajax({
      type: "GET",
      url: "../Controller/getUnreadNotificationsByNickname.php",
      datatype: "json",
      success: function (response) {
        if (response > 0) {
          $("#notifications").text(response);
          $("#notifications").addClass("bg-danger");
        } else {
          $("#notifications").text("");
        }
      },
      error: function (xhr, status, error) {
        console.error('Errore nella richiesta AJAX:', status, error);
      }
    });
  }, 500);
});