$(document).ready(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const follow = urlParams.get('follow')
    if (follow != null) {
        url = '../Controller/getFeedPostsController.php?follow=1';
        followParameter = true;
    } else {
        url = '../Controller/getFeedPostsController.php';
        followParameter = false;
    }
    $.ajax({
        type: 'GET',
        url: '../Controller/getProfileNicknameController.php',
        dataType: 'json',
        success: function (response) {
            if (response !== "error") {
                sessionNickname = response;
                let htmlCode = `
                <div class="row mb-4">
                    ${sessionNickname ? `
                        <div class="col-2 col-lg-1 text-center">
                            <a href="profile.html?nickname=${sessionNickname}">
                                <img id="profilePhoto" src="" alt="Account Image" class="img-fluid rounded-circle">
                            </a>
                        </div>
                    ` : ''}
                    <div class="col-4 col-lg-5 align-self-center text-end">
                        <a href="feed.html" class="btn ${!followParameter ? 'fw-bold text-decoration-underline' : ''}">Suggeriti</a>
                    </div>
                    <div class="col-4 col-lg-5 align-self-center text-justify">
                        <a href="feed.html?follow=1" class="btn ${followParameter ? 'fw-bold text-decoration-underline' : ''}">Seguiti</a>
                    </div>
                    ${sessionNickname ? `
                        <div class="col-2 col-lg-1 align-self-center text-center fs-3">
                            <a href="profile.html?nickname=${sessionNickname}&favourite=true" class="text-dark" title="profile"><em class="fa fa-star-o"></em></a>
                        </div>
                    ` : ''}
                </div>
                `;
                getProfilePhoto(sessionNickname);
            } else {
                let htmlCode = `
                <div class="row mb-4">
                    <div class="col-6 align-self-center text-end">
                        <a href="feed.html" class="btn ${!followParameter ? 'fw-bold text-decoration-underline' : ''}">Suggeriti</a>
                    </div>
                    <div class="col-6 align-self-center text-justify">
                        <a href="feed.html?follow=1" class="btn ${followParameter ? 'fw-bold text-decoration-underline' : ''}">Seguiti</a>
                    </div>
                </div>
                `;
            }
            $("#userData").append(htmlCode);
        },
        error: function (xhr, status, error) {
            console.error('Errore nella richiesta AJAX:', status, error);
        }
    });
    $.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        success: function (response) {
            if (response === "notlogged") {
                window.location.replace("login.html");
            } else {
                response.forEach(function (post, index) {
                    let postHtml = `
                    <div class="row mb-2">
                        <div class="col-2 col-lg-1 text-center">
                            <a href="profile.html?nickname=${post.nickname}">
                                <img src="${post.photo_url}" alt="Account Image" class="img-fluid rounded-circle">
                            </a>
                        </div>
                        <div class="col-7 col-lg-9 align-self-center">
                            <a href="profile.html?nickname=${post.nickname}" class="btn p-0">${post.name} ${post.surname}</a>
                            <a href="profile.html?nickname=${post.nickname}" class="btn text-muted p-0">@${post.nickname}</a>
                            <a class="btn disabled text-muted p-0 px-3">&#9679 ${post.datetime}</a>
                        </div>
                        ${post.following != null ?
                            `<div class="col-3 col-lg-2 align-self-center text-center">
                                <button class="follow${post.nickname} btn btn-secondary form-control" onclick="follow('${post.nickname}', ${post.id})">
                                    ${post.following == 1 ? 'Segui già' : 'Segui'}
                                </button>
                            </div>` : ``
                        }
                    </div>
                    <div class="row mb-2">
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                //TODO
                            <h2>${post.title}</h2>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                            <div id="carouselExampleIndicators${index}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    ${post.photos.map((photo, photoIndex) => `
                                        <button type="button" data-bs-target="#carouselExampleIndicators${index}" 
                                                data-bs-slide-to="${photoIndex}" 
                                                aria-label="Slide ${photoIndex}" 
                                                class="${photoIndex === 0 ? 'active' : ''}" 
                                                aria-current="${photoIndex === 0 ? 'true' : 'false'}">
                                        </button>
                                    `).join('')}
                                </div>
                                <div class="carousel-inner rounded">
                                    ${post.photos.map((photo, photoIndex) => `
                                        <div class="carousel-item ${photoIndex === 0 ? 'active' : ''}">
                                            <img src="${photo.photo_url}" class="d-block w-100" alt="Post image">
                                        </div>
                                    `).join('')}
                                </div>
                                <button class="carousel-control-prev" type="button" 
                                        data-bs-target="#carouselExampleIndicators${index}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" 
                                        data-bs-target="#carouselExampleIndicators${index}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-10 col-lg-11 align-self-center ms-auto">
                            <p class="lh-sm"> ${post.description}</p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-2 offset-2">
                            <a href="itinerary.html?itinerary_id=${post.itinerary_id}" class="btn text-muted p-0" title="itinerary">
                                <em class="fa fa-map-o"></em>
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <a id="commentsCount${post.id}" href="comment.html?post_id=${post.id}" class="btn text-muted p-0" title="comment">
                                ` + getCommentCount(post.id) + `
                            </a>
                        </div>
                        <div class="col-2 text-center">
                            <button id="likesCount${post.id}" class="btn text-muted p-0" onclick="setLike(${post.id})">
                                ` + getLikeCount(post.id) + `
                            </button>
                        </div>
                        <div class="col-2 text-center">
                            <button id="starsCount${post.id}" class="btn text-muted p-0" onclick="setFavourite(${post.id})">
                                ` + getFavouriteCount(post.id) + `
                            </button>
                        </div>
                        <div class="col-2 text-end">
                            <button type="button" class="btn text-muted p-0 px-3" data-bs-toggle="modal" data-bs-target="#modal" onclick="getFollower(${post.id})">
                                <em class="fa fa-share"></em>
                            </button>
                        </div>
                    </div>
                    <hr>
                `;
                    $("#posts").append(postHtml);
                });
            }
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

