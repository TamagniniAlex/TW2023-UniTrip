$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const post_id = urlParams.get('post_id')
    if (post_id == null || post_id == "") {
        window.location.replace("../View/feed.html");
    }
    $.ajax({
        type: 'GET',
        url: '../Controller/getPostByIdController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (response) {
            if (response === "error") {
                window.location.replace("feed.html");
            } else {
                var postHtml = `
                <div class="row mb-2">
                    <div class="col-2 col-lg-1 text-center">
                        <a href="profile.html?nickname=${response.nickname}">
                            <img src="${response.photo_url}" alt="Account Image" class="img-fluid rounded-circle">
                        </a>
                    </div>
                    <div class="col-7 col-lg-9 align-self-center">
                        <a href="profile.html?nickname=${response.nickname}" class="btn p-0">${response.name} ${response.surname}</a>
                        <a href="profile.html?nickname=${response.nickname}" class="btn text-muted p-0">@${response.nickname}</a>
                        <a class="btn disabled text-muted p-0 px-3">&#9679 ${response.datetime}</a>
                    </div>
                    ${response.following != -1 ?
                        `<div class="col-3 col-lg-2 align-self-center text-center">
                            <button class="shadow-none follow${response.nickname} btn btn-secondary form-control" onclick="follow('${response.nickname}')">
                                ${response.following == 1 ? 'Segui già' : 'Segui'}
                            </button>
                        </div>` : ``
                    }
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <h5>${response.title}</h5>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <div id="carouselExampleIndicators0" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                ${response.photos.map((photo, photoIndex) => `
                                    <button type="button" data-bs-target="#carouselExampleIndicators0" 
                                        data-bs-slide-to="${photoIndex}" 
                                        aria-label="Slide ${photoIndex}" 
                                        class="${photoIndex === 0 ? 'active' : ''}" 
                                        aria-current="${photoIndex === 0 ? 'true' : ''}">
                                    </button>
                                `).join('')}
                            </div>
                            <div class="carousel-inner rounded">
                                ${response.photos.map((photo, photoIndex) => `
                                    <div class="carousel-item ${photoIndex === 0 ? 'active' : ''}">
                                        <img src="${photo.photo_url}" class="d-block w-100" alt="Post image">
                                    </div>
                                `).join('')}
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators0" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators0" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-10 col-lg-11 align-self-center ms-auto">
                        <p class="lh-sm"> ${response.description}</p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-2 offset-2">
                        <a href="itinerary.html?itinerary_id=${response.itinerary_id}" class="shadow-none btn text-muted p-0">
                            <i class="fa fa-map-o"></i>
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <a id="commentsCount${post_id}" href="comment.html?post_id=${post_id}" class="shadow-none btn text-muted p-0">
                            ` + getCommentCount(post_id) + `
                        </a>
                    </div>
                    <div class="col-2 text-center">
                        <button id="likesCount${post_id}" class="shadow-none btn text-muted p-0" onclick="setLike(${post_id})">
                            ` + getLikeCount(post_id) + `
                        </button>
                    </div>
                    <div class="col-2 text-center">
                        <button id="starsCount${post_id}" class="shadow-none btn text-muted p-0" onclick="setFavourite(${post_id})">
                            ` + getFavouriteCount(post_id) + `
                        </button>
                    </div>
                    <div class="col-2 text-end">
                        <button type="button" class="shadow-none btn text-muted p-0 px-2" data-bs-toggle="modal" data-bs-target="#modal" onclick="getFollower(${post_id})">
                            <i class="fa fa-share"></i>
                        </button>
                    </div>
                </div>
                `;
            }
            $("#post").append(postHtml);
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });

    $.ajax({
        type: 'GET',
        url: '../Controller/getCommentController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (response) {
            response.forEach(function (comment) {
                $('#comments').append(`
                    <div class="row">
                        <div class="col-2 col-lg-1 text-center">
                            <a href="profile.html?nickname=`+ comment.nickname + `">
                                <img src= `+ comment.photo_url + ` alt="Account Image" class="img-fluid rounded-circle">
                            </a>                
                        </div>
                        <div class="col-10 col-lg-11 align-self-center">
                            <a href="profile.html?nickname=`+ comment.nickname + `" class="btn p-0">
                                ` + comment.name + ` ` + comment.surname + `
                            </a>
                            <a href="profile.html?nickname=`+ comment.nickname + `" class="btn text-muted p-0">@` + comment.nickname + `</a>
                            <a class="btn disabled text-muted p-0 px-3">&#9679 ` + comment.datetime + `</a>
                            <p class="lh-sm m-0"> ` + comment.comment + ` </p>
                        </div>
                    </div>
                    <hr class="my-2">
                `);
            });
        }
    });

    $.ajax({
        type: 'GET',
        url: '../Controller/getProfileNicknameController.php',
        dataType: 'json',
        success: function (response) {
            $("#sendComment").click(function () {
                if (response === "error") {
                    window.location.replace("login.html");
                } else {
                    sendComment(post_id);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });

});

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
                        document.getElementById("starsCount" + post_id).innerHTML = '<i  class="text-warning fa fa-star"></i> ' + stars;
                    }
                    else {
                        document.getElementById("starsCount" + post_id).innerHTML = '<i class="fa fa-star-o"></i> ' + stars;
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Errore nella richiesta AJAX:', status, error);
                    document.getElementById("likesCount" + post_id).innerHTML = "dioca";
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
                    document.getElementById("likesCount" + post_id).innerHTML = "dioca"; //TODO
                }
            });
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

function follow(nickname) {
    $.ajax({
        type: 'GET',
        url: '../Controller/setFollowController.php?to=' + nickname,
        dataType: 'json',
        success: function (result) {
            var buttons = document.getElementsByClassName("follow" + nickname);
            for (var i = 0; i < buttons.length; i++) {
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

function sendComment($post_id) {
    var comment = document.getElementById("inputComment").value;
    $.ajax({
        type: 'POST',
        url: '../Controller/addCommentController.php',
        data: { comment: comment, post_id: $post_id },
        dataType: 'json',
        success: function (result) {
            if (result === "success") {
                window.location.reload();
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function getFollower(post_id) {
    console.log(post_id);
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