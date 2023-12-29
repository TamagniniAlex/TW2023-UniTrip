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
                    if (response === "error") {
                        window.location.replace("feed.html");
                    } else {
                        var profileHtml = `
                        <div class="col-12 px-5">
                        <div class="row mb-3">
                            <div class="col-3 col-lg-1 text-center"> 
                                <a href="profile.html?nickname=` + nickname + `">
                                    <img id="profilePhoto" src="" alt="Account Image" class="img-fluid rounded-circle">
                                </a>
                            </div>`;
                        getProfilePhoto(nickname);
                        if (sessionNickname != "" && sessionNickname != nickname) {
                            profileHtml += `
                            <div class="col-4 col-lg-2 offset-5 offset-lg-9 align-self-center text-center">
                                <button id="follow" onclick="follow('${nickname}')" class="btn btn-secondary form-control">
                                    ${response.following === 1 ? 'Segui già' : 'Segui'}
                                </button>
                            </div>
                        </div>`;
                        } else {
                            profileHtml += ` 
                            <div class="col-4 col-lg-2 offset-5 offset-lg-9 align-self-center text-center">
                                <button onclick="logout()" class="btn btn-danger form-control">
                                    Logout
                                </button>
                            </div>
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
                                <em class="fa fa-birthday-cake text-muted"> Nato il ` + response.birth_date + `</em>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <em class="fa fa-calendar text-muted"> Registrato il ` + response.join_date + `</em>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-12">
                                <p class="text-muted p-0 d-inline"> <strong>` + response.following_count + `</strong> Following</p> 
                                <p class="text-muted p-0 px-4 d-inline"> <strong>` + response.followers_count + `</strong> Followers</p>  
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
                        profileHtml += `</div>`;
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
                                                <em class="fa fa-map-o"></em>
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
                                            <button type="button" class="btn text-muted p-0" data-bs-toggle="modal" data-bs-target="#modal" onclick="getFollower(${post.id})">
                                                <em class="fa fa-share"></em>
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

function logout() {
    $.ajax({
        type: 'GET',
        url: '../Controller/logoutController.php',
        dataType: 'json',
        success: function (result) {
            if (result === "success") {
                window.location.replace("index.html");
            }
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
}