$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    $.ajax({
            type: 'GET',
            url: '../Controller/getNotificationsByNickname.php',
            dataType: 'json',
            success: function (response) {
                if (response === "error") {
                    window.location.replace("feed.html");
                } else {
                    response.forEach(notification => {
                    let postHtml = `
                <div class="row align-items-center border-2">
                    <div class="col-4">
                        <a href="profile.html?nickname=` + notification.from_username + `">
                            <img src=` + notification.photo_url + ` alt="Account Image" class="img-fluid rounded-circle" style="max-width: 60px;">
                        </a>
                    </div>
                    <div class="col-8">
                        <a href="profile.html?nickname=` + notification.from_username + `" class="btn btn-link p-0  text-decoration-none">
                            ` + notification.from_username + `
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>` + notification.message + `</p>
                    </div>
                </div>
                
                    `;
                    $("#notify").append(postHtml);
                }
                )}
            },
            error: function (xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
            }
        });
});