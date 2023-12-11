$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const post_id = urlParams.get('post_id')
    $.ajax({
        type: 'GET',
        url: '../Controller/getCommentController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (response) {
            console.log(response);  
            response.forEach(function (comment, index) {
                    $('#comments').append(`
                    <div class="row">
                <div class="col-2 col-lg-1 text-center">
                    <a href="profile.php?nickname= " `+ comment.nickname+ ` ">
                        <img src= `+comment.photo_url+` alt="Account Image" class="img-fluid rounded-circle">
                    </a>                
                </div>
                <div class="col-10 col-lg-11 align-self-center">
                <a href="profile.php?nickname= " `+ comment.nickname+ ` " class="btn p-0">
                    ` +comment.name + ` ` + comment.surname + `
                    </a>
                    <a href="profile.php?nickname="`+comment.nickname +`" class="btn text-muted p-0">@`+ comment.nickname +`</a>
                    <a class="btn disabled text-muted p-0 px-3">&#9679 ` + comment.datetime+ `</a>
                    <p class="lh-sm"> ` + comment.comment +` </p>
                </div>
            </div>
            <hr> `);
                
            });
        }
    });

    $.ajax({
        type: 'GET',
        url: '../Controller/getPostByIdController.php?post_id=' + post_id,
        dataType: 'json',
        success: function (response) {
                    var postHtml = `
                    <div class="row mb-2">
                        <div class="col-2 col-lg-1 text-center">
                            <a href="profile.php?nickname=${response.nickname}">
                                <img src="${response.photo_url}" alt="Account Image" class="img-fluid rounded-circle">
                            </a>
                        </div>
                        <div class="col-7 col-lg-9 align-self-center">
                            <a href="profile.php?nickname=${response.nickname}" class="btn p-0">${response.name} ${response.surname}</a>
                            <a href="profile.php?nickname=${response.nickname}" class="btn text-muted p-0">@${response.nickname}</a>
                            <a class="btn disabled text-muted p-0 px-3">&#9679 ${response.datetime}</a>
                        </div>
                        ${response.following != null ?
                            `<div class="col-3 col-lg-2 align-self-center text-center">
                                <button class="follow${response.nickname} btn btn-secondary form-control" onclick="follow('${response.nickname}')">
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
                                <button class="carousel-control-prev" type="button" 
                                        data-bs-target="#carouselExampleIndicators0" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" 
                                        data-bs-target="#carouselExampleIndicators0" data-bs-slide="next">
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

                    <div class="row mb-4">
                        <div class="col-2 offset-2">
                            <a href="itinerary.php?itinerary_id=${response.itinerary_id}" class="btn text-muted p-0">
                            <i class="fa fa-map-o"></i>
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <a id="commentsCount${response.id}" href="comment.html?post_id=${response.id}" class="btn text-muted p-0">
                                ` + getCommentCount(response.id) + `
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <button id="likesCount${response.id}" class="btn text-muted p-0" onclick="setLike(${response.id})">
                                ` + getLikeCount(response.id) + `
                            </button>
                        </div>
                        <div class="col-2 text-center">
                            <button id="starsCount${response.id}" class="btn text-muted p-0" onclick="setFavourite(${response.id})">
                                ` + getFavouriteCount(response.id) + `
                            </button>
                        </div>
                        <div class="col-2 text-end">
                            <!--TODO-->
                            <a href="#" class="btn text-muted p-0 px-3"><i class="fa fa-share"></i></a>
                        </div>
                    </div>
                `;
                    $("#post").append(postHtml);
            
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
});
function getProfilePhoto(nickname) {
    $.ajax({
        type: 'GET',
        url: '../Controller/getProfilePhotoController.php?nickname=' + nickname,
        dataType: 'json',
        success: function (photo_url) {
            document.getElementById("profilePhoto").src = photo_url;
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

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
            document.getElementById("starsCount" + post_id).innerHTML = '<i class="fa fa-star-o"></i> ' + stars;
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function setFavourite(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/postFavouriteController.php?post_id=' + post_id,
        dataType: 'html',
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
            document.getElementById("likesCount" + post_id).innerHTML = '<i class="fa fa-heart-o"></i> ' + likes;
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}

function setLike(post_id) {
    $.ajax({
        type: 'GET',
        url: '../Controller/postLikeController.php?post_id=' + post_id,
        dataType: 'html',
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
        url: '../Controller/followController.php?to=' + nickname,
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

