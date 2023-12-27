
function getCommentCount(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/getCommentCountController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (comments) {
            document.getElementById("commentsCount" + post_id).innerHTML = '<i class="fa fa-comment-o"></i> ' + comments;
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function getFavouriteCount(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/getFavouriteCountController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (stars) {
            $.ajax({
                type: 'GET',
                url: '../Controller/getWasPostStarred.php?post_id=' + post_id,
                dataType: 'json',
                success: function (wasStarred) {
                    if (wasStarred == 1) {
                        document.getElementById("starsCount" + post_id).innerHTML = '<i class="text-warning fa fa-star"></i> ' + stars;
                    }
                    else {
                        document.getElementById("starsCount" + post_id).innerHTML = '<i class="fa fa-star-o"></i> ' + stars;
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Errore nella richiesta AJAX:', status, error);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function setFavourite(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/setFavouriteController.php?post_id=' + post_id,
        dataType: 'json',
        success: function () {
            getFavouriteCount(post_id);
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function setLike(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/setLikeController.php?post_id=' + post_id,
        dataType: 'json',
        success: function () {
            getLikeCount(post_id);
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function getLikeCount(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/getLikeCountController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (likes) {
            $.ajax({
                type: 'GET',
                url: '../Controller/getWasPostLiked.php?post_id=' + post_id,
                dataType: 'json',
                success: function (wasLiked) {
                    if (wasLiked == 1) {
                        document.getElementById("likesCount" + post_id).innerHTML = '<i class="text-danger fa fa-heart"></i> ' + likes;
                    }
                    else {
                        document.getElementById("likesCount" + post_id).innerHTML = '<i class="fa fa-heart-o"></i> ' + likes;
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Errore nella richiesta AJAX:', status, error);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function follow(nickname, id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/setFollowController.php?post_id='+id,
        dataType: 'json',
        success: function (result) {
            let buttons = document.getElementsByClassName("follow" + nickname);
            for (let i = 0; i < buttons.length; i++) {
                if (result === 1) {
                    buttons[i].innerHTML = 'Segui già';
                } else {
                    buttons[i].innerHTML = 'Segui';
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function getFollower(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/getFollowerInformationController.php',
        dataType: 'json',
        success: function (result) {
            if (result !== "error") {
                $("#friendList").empty();
                result.forEach(function (follower, index) {
                    var modalBody = `
                    <div class="row mb-2">
                        <div class="col-2 text-center">
                            <img src="${follower.photo_url}" alt="Account Image" class="img-fluid rounded-circle">
                        </div>
                        <div class="col-7 align-self-center">
                            <a href="profile.html?nickname=${follower.nickname}" class="btn p-0">${follower.name} ${follower.surname}</a>
                            <a href="profile.html?nickname=${follower.nickname}" class="btn text-muted p-0">@${follower.nickname}</a>
                        </div>
                        <div class="col-3 align-self-center text-center">
                            <button id="share${follower.nickname}" class="shadow-none btn btn-secondary form-control" onclick="sharePost('${follower.nickname}', ${post_id})">
                                Condividi
                            </button>
                        </div>
                    </div>
                    <hr>
                    `;
                    $("#friendList").append(modalBody);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function sharePost(to_username, post_id) {
    $.ajax({
        type: 'POST',
        url: '../Controller/addMessageController.php',
        data: {
            to_username: to_username,
            message: "Guarda questo post!",
            post_id: post_id
        },
        dataType: 'json',
        success: function (result) {
            if (result === "success") {
                $("#share" + to_username).addClass("disabled");
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}