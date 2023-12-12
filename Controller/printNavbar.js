$(document).ready(function () {
  var focusOn = window.location.pathname.split('/').pop().split('.')[0];
  html = `
  <nav class="navbar bg-light fixed-bottom border-top border-2">
    <div class="container">
      <div class="d-flex justify-content-around w-100 fs-3">
        <a href="feed.html" class="text-center text-` + (focusOn == "feed" ? "dark" : "muted") + `"><i class="fa fa-home"></i></a>
        <a href="search.html" class="text-center text-` + (focusOn == "search" ? "dark" : "muted") + `"><i class="fa fa-search"></i></a>
        <a href="addPost.html" class="text-center text-` + (focusOn == "addPost" ? "dark" : "muted") + `"><i class="fa fa-plus"></i></a>
        <a href="#" class="text-center text-` + (focusOn == "notifications" ? "dark" : "muted") + `"><i class="fa fa-bell-o"></i></a>
        <a href="#" class="text-center text-` + (focusOn == "messages" ? "dark" : "muted") + `"><i class="fa fa-envelope-o"></i></a>
      </div>
    </div>
  </nav>`
  $("#navbar").append(html);
});