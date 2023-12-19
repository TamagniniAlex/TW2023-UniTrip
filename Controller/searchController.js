$(document).ready(function () {
    inputSearch.addEventListener('input', function (event) {
        const inputValue = event.target.value;
        $.ajax({
            type: 'GET',
            url: '../Controller/getPartialSearchController.php?text=' + inputValue,
            dataType: 'json',
            success: function (result) {
                $("#searchResult").empty();
                for (let i = 0; i < result.length; i++) {
                    if (result[i].id != undefined) {
                        $("#searchResult").append("<li><a href='../View/comment.html?post_id=" + result[i].id + "'>" + result[i].title + "</a></li>");
                    } else {
                        $("#searchResult").empty();
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Errore nella richiesta AJAX:', status, error);
            }
        });
    });
});

function printPosts() {
    $("#posts").empty();
    $.ajax({
        type: 'GET',
        url: '../Controller/getPartialSearchController.php?text=' + $("#inputSearch").val(),
        dataType: 'json',
        success: function (result) {
            result.forEach(function (post, index) {
                var profileHtml = `
            <div class="col-12 col-lg-6 col-xxl-4 px-5">
                <h5>${post.title}</h5>
                <div id="carouselExampleIndicators${index}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        ${post.photos.map((photo, index) => `
                            <button type="button" data-bs-target="#carouselExampleIndicators${index}" 
                                data-bs-slide-to="${index}" aria-label="Slide ${index}" 
                                class="${index === 0 ? 'active' : ''}" aria-current="${index === 0 ? 'true' : ''}">
                            </button>
                        `).join('')}
                    </div>
                    <div class="carousel-inner rounded">
                        ${post.photos.map((photo, index) => `
                            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                <img src="${photo.photo_url}" class="d-block w-100" alt="Post image">
                            </div>
                        `).join('')}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators${index}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators${index}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="row mb-2">
                    <p class="lh-sm">${post.description}</p>
                </div>
                <div class="row mb-4">
                    <div class="col-1">
                        <a href="itinerary.html?itinerary_id=${post.itinerary_id}" class="shadow-none btn text-muted p-0">
                            <i class="fa fa-map-o"></i>
                        </a>                        
                    </div>
                    <div class="col-3 text-end p-0">
                        <a id="commentsCount${post.id}" href="comment.html?post_id=${post.id}" class="shadow-none btn text-muted p-0">
                            ` + getCommentCount(post.id) + `
                        </a>                        
                    </div>
                    <div class="col-4 text-center p-0">
                        <button id="likesCount${post.id}" class="shadow-none btn text-muted p-0" onclick="setLike(${post.id})">
                            ` + getLikeCount(post.id) + `
                        </button>                    
                    </div>
                    <div class="col-3 text-start p-0">
                        <button id="starsCount${post.id}" class="shadow-none btn text-muted p-0" onclick="setFavourite(${post.id})">
                            ` + getFavouriteCount(post.id) + `
                        </button>                      
                    </div>
                    <div class="col-1 p-0">
                        <button type="button" class="shadow-none btn text-muted p-0" data-bs-toggle="modal" data-bs-target="#modal" onclick="getFollower(${post.id})">
                            <i class="fa fa-share"></i>
                        </button>
                    </div>
                </div>
            </div>`;
                $("#posts").append(profileHtml);
            });
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
                    document.getElementById("likesCount" + post_id).innerHTML = "dioca";
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