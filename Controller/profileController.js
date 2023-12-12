$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const nickname = urlParams.get('nickname');
    const favourite = urlParams.get('favourite');
    const like = urlParams.get('like');
    var sessionNickname = "";
    if (nickname == null || nickname == "") {
        window.location.replace("../View/feed.html");
    }
    //TODO check if nickname is valid
    $.ajax({
        type: 'GET',
        url: '../Controller/getProfileNicknameController.php',
        dataType: 'json',
        success: function (response) {
            if (response !== "error") {
                sessionNickname = response;
            }
            $.ajax({
                type: 'GET',
                url: '../Controller/getProfileDataController.php?nickname=' + nickname,
                dataType: 'json',
                success: function (response) {
                    var profileHtml = `
                        <div class="row mb-3">
                            <div class="col-2 col-lg-1 text-center"> 
                                <a href="profile.html?nickname=` + nickname + `">
                                    <img id="profilePhoto" src="" alt="Account Image" class="img-fluid rounded-circle">
                                </a>
                            </div>`;
                    getProfilePhoto(nickname);
                    if (sessionNickname != "" && sessionNickname != nickname) {
                        profileHtml += `
                            <div class="col-3 col-lg-2 offset-7 offset-lg-9 align-self-center text-center">
                                <button id="follow" onclick="follow('${nickname}')" class="btn btn-secondary form-control">
                                    ${response.following === 1 ? 'Segui già' : 'Segui'}
                                </button>
                            </div>
                        </div>`;
                    } else {
                        profileHtml += ` 
                            </div>`;
                    }
                    profileHtml += `
                        <div class="row mb-2">
                            <h4 class="fw-bold text-start">` + response.name + " " + response.surname + `</h4>
                        </div>
                        <div class="row mb-2">
                            <h6 class="text-muted text-start">@` + nickname + `</h6>
                        </div>
                        <div class="row mb-1">
                            <p class="text-muted text-start">` + response.description + `</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <i class="fa fa-birthday-cake text-muted"> Nato il ` + response.birth_date + `</i>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <i class="fa fa-calendar text-muted"> Registrato il ` + response.join_date + `</i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-12">
                                <a class="btn text-muted p-0"> <strong>` + response.following_count + `</strong> Following</a> 
                                <a class="btn text-muted p-0 px-4"> <strong>` + response.followers_count + `</strong> Followers</a>  
                            </div>
                        </div>`;
                    if (sessionNickname == nickname) {
                        profileHtml += `
                            <div class="row text-center">
                                <div class="col-4">
                                    <a href="profile.html?nickname=${sessionNickname}" class="btn ${!like && !favourite ? 'fw-bold text-decoration-underline' : ''}">Posts</a>
                                </div>
                                <div class="col-4">
                                    <a href="profile.html?nickname=${sessionNickname}&like=true" class="btn ${like === 'true' ? 'fw-bold text-decoration-underline' : ''}">Mi piace</a>
                                </div>
                                <div class="col-4">
                                    <a href="profile.html?nickname=${sessionNickname}&favourite=true" class="btn ${favourite === 'true' ? 'fw-bold text-decoration-underline' : ''}">Preferiti</a>
                                </div>
                            </div>`;
                    }
                    $("#userData").append(profileHtml);
                    $.ajax({
                        type: 'GET',
                        url: '../Controller/getProfilePostsController.php?nickname=' + nickname + '&like=' + like + '&favourite=' + favourite,
                        dataType: 'json',
                        success: function (response) {
                            response.forEach(function (post, index) {
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
                                            <a href="itinerary.html?itinerary_id=${post.itinerary_id}" class="btn text-muted p-0">
                                                <i class="fa fa-map-o"></i>
                                            </a>                        
                                        </div>
                                        <div class="col-3 text-end p-0">
                                            <a id="commentsCount${post.id}" href="comment.html?post_id=${post.id}" class="btn text-muted p-0">
                                                ` + getCommentCount(post.id) + `
                                            </a>                        
                                        </div>
                                        <div class="col-4 text-center p-0">
                                            <button id="likesCount${post.id}" class="btn text-muted p-0" onclick="setLike(${post.id})">
                                                ` + getLikeCount(post.id) + `
                                            </button>                    
                                        </div>
                                        <div class="col-3 text-start p-0">
                                            <button id="starsCount${post.id}" class="btn text-muted p-0" onclick="setFavourite(${post.id})">
                                                ` + getFavouriteCount(post.id) + `
                                            </button>                      
                                        </div>
                                        <div class="col-1 p-0">
                                            <!--TODO-->
                                            <a href="#" class="btn text-muted p-0"><i class="fa fa-share"></i></a>
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
            var button = document.getElementById("follow");
            if (result === 1) {
                button.innerHTML = 'Segui già';
            } else {
                button.innerHTML = 'Segui';
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}