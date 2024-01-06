$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: '../Controller/getNotificationsByNickname.php',
        dataType: 'json',
        success: function (response) {
            if (response === "error") {
                window.location.href = "../View/feed.html";
            } else {
                response.forEach(notification => {
                    $("#notify").append(`
                        <div class="row">
                            <div class="col-2 col-lg-1 text-center">
                                <a href="profile.html?nickname=`+ notification.from_username + `">
                                    <img src= `+ notification.photo_url + ` alt="Account Image" class="img-fluid rounded-circle">
                                </a>
                            </div>
                            <div class="col-10 col-lg-11 align-self-center">
                                <a href="profile.html?nickname=`+ notification.from_username + `" class="btn p-0"><strong>
                                    ` + notification.name + ` ` + notification.surname + `
                                </strong></a>
                                <a href="profile.html?nickname=`+ notification.from_username + `" class="btn text-muted px-2 py-0">@` + notification.from_username + `</a>
                                <p class="d-inline text-muted m-0 px-3 float-end">&#9679 ` + notification.datetime + `</p>
                                <p class="lh-sm m-0 ${notification.post_id !== null ? `clickable" onClick='OpenPost(${notification.post_id})'` : `"`}>` + notification.message + ` </p>
                            </div>
                        </div>
                        <hr>
                    `);               
               })
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});

function OpenPost($post_id) {
    window.location.href = "../View/comment.html?post_id=" + $post_id;
}