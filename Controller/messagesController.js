$(document).ready(function () {
    $.ajax({
        type: 'GET',
        url: '../Controller/getChatsController.php',
        dataType: 'json',
        success: function (chats) {
            if (chats === "error") {
                window.location.href = "../View/index.html";
            } else {
                for (let i = 0; i < chats.length; i++) {
                    $('#chat').append(`
                        <div class="row" onClick="openChat('${chats[i].chat_with}')">
                            <div class="col-2 col-lg-1 text-center">
                                <a href="profile.html?nickname=`+ chats[i].chat_with + `">
                                    <img src= `+ chats[i].photo_url + ` alt="Account Image" class="img-fluid rounded-circle">
                                </a>
                            </div>
                            <div class="col-10 col-lg-11 align-self-center">
                                <a href="profile.html?nickname=`+ chats[i].chat_with + `" class="btn p-0"><strong>
                                    ` + chats[i].name + ` ` + chats[i].surname + `
                                </strong></a>
                                <a href="profile.html?nickname=`+ chats[i].chat_with + `" class="btn text-muted px-2 py-0">@` + chats[i].chat_with + `</a>
                                <p class="d-inline text-muted m-0 px-3 float-end">&#9679 ` + chats[i].datetime + `</p>
                                <p class="lh-sm m-0"> ${chats[i].mine === "true" ? 'Tu:' : ''} ` + chats[i].message + ` </p>
                            </div>
                        </div>
                        <hr>
                    `);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});

function openChat($chat_with) {
    window.location.href = "../View/chat.html?chat_with=" + $chat_with;
}