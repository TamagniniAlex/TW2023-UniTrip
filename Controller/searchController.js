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