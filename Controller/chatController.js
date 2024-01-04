$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const chat_with = urlParams.get('chat_with')
    if (chat_with == null || chat_with == "") {
        window.location.replace("../View/feed.html");
    }
    $.ajax({
        type: 'GET',
        url: '../Controller/getProfileDataController.php?nickname=' + chat_with,
        dataType: 'json',
        success: function (data) {
            if (data === "error") {
                window.location.href = "../View/index.html";
            } else {
                $.ajax({
                    type: 'GET',
                    url: '../Controller/getProfilePhotoController.php?nickname=' + chat_with,
                    dataType: 'json',
                    success: function (photo) {
                        if (photo === "error") {
                            window.location.href = "../View/index.html";
                        } else {
                            $('#user').append(`
                                <div class="row">
                                    <div class="col-2 col-lg-1 text-center">
                                        <a href="profile.html?nickname=`+ chat_with + `">
                                            <img src= `+ photo + ` alt="Account Image" class="img-fluid rounded-circle">
                                        </a>
                                    </div>
                                    <div class="col-10 col-lg-11 align-self-center">
                                        <a href="profile.html?nickname=`+ chat_with + `" class="btn p-0"><strong>
                                            ` + data.name + ` ` + data.surname + `
                                        </strong></a>
                                        <a href="profile.html?nickname=`+ chat_with + `" class="btn text-muted px-2 py-0">@` + chat_with + `</a>
                                    </div>
                                </div>
                            `);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Errore nella richiesta AJAX:', status, error);
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
    $.ajax({
        type: 'GET',
        url: '../Controller/getChatsAllController.php?chat_with=' + chat_with,
        dataType: 'json',
        success: function (chats) {
            if (chats === "error") {
                window.location.href = "../View/index.html";
            } else {
                for (let i = 0; i < chats.length; i++) {
                    $('#chat').append(`
                        <div class="row">
                            <div class="align-self-center ${chats[i].post_id !== null ? `clickable" onClick='OpenPost(" + chats[i].post_id + ")'` : `"`}>
                                <p class="d-inline text-muted m-0 px-3 float-end">&#9679 ` + chats[i].datetime + `</p>
                                <p class="m-0 px-3"> ${chats[i].mine === "true" ? 'Tu:' : ''} ` + chats[i].message + ` </p>
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

function OpenPost($post_id) {
    window.location.href = "../View/comment.html?post_id=" + $post_id;
}

function sendMessage() {
    var message = document.getElementById("inputMessage").value;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const chat_with = urlParams.get('chat_with')
    if (chat_with == null || chat_with == "") {
        window.location.replace("../View/feed.html");
    }
    $.ajax({
        type: 'POST',
        url: '../Controller/addMessageController.php',
        data: { message: message, to_username: chat_with },
        dataType: 'json',
        success: function (result) {
            if (result === "success") {
                $('#inputMessage').value = "";
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}