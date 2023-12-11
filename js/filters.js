document.addEventListener("DOMContentLoaded", function () {
                        
    //Recupere le DOM du SELECT
    const categorySelect = document.getElementById("cat-select");
    const cat = '';


  
    displayPost(cat);

    categorySelect.addEventListener("change", function() {

        
        const categoryId = categorySelect.value;
        displayPost(categoryId);

        
    });

});


function displayPost(cat){

    var bloggerElt = document.getElementById("blogger");
    bloggerElt.textContent = '';

    var xhr = new XMLHttpRequest();

    cat === '' ?  xhr.open('GET', '/wp-json/wp/v2/posts?per_page=20') :  xhr.open('GET', '/wp-json/wp/v2/posts?categories=' + cat + '&per_page=20')
   

        //xhr.onload = async function() {
        xhr.onload = function() {


            if (xhr.status === 200) {

                // La réponse est au format JSON
                var posts = JSON.parse(xhr.responseText);

                //for (const item of posts) {
                posts.forEach( async(post) => {
                    
                   
                    // Accédez à l'URL de la thumbnail
                    // genre : http://wordpress-defaut.local/wp-json/wp/v2/media/71
                    var thumbnailUrl = post._links['wp:featuredmedia'][0].href;

                    //Ne prend que l'id à la fin de l'url : 71
                    const featuredMediaId = thumbnailUrl.split('/').pop();

                    //Fonction qui appelle l'api media wp-json/wp/v2/media/71
                    //pour convertir l'id media en URL
                    let featuredMediaUrl = await fetchMedia(featuredMediaId);
                    
                    
                    /* Templating */

                    const divElt = document.createElement('div');
                    divElt.classList.add('divImg');

                    const imgElt = document.createElement('img');
                    imgElt.src = featuredMediaUrl;

                    const titleH3 = document.createElement("h3");
                    titleH3.classList.add("title-post", "text-center");
                    titleH3.textContent = post.title.rendered;

                    divElt.appendChild(imgElt);
                    divElt.appendChild(titleH3);
                    bloggerElt.appendChild(divElt);




            })
        } else {
            console.error('Erreur lors de la requête AJAX');
            }
            
        }
        xhr.send();

}


function fetchMedia(thumbnailId){

    const urLocation = window.location.origin;

    return fetch(`${urLocation}/wp-json/wp/v2/media/${thumbnailId}`)

    .then(response => response.json())

    .then(thumbnail => thumbnail.source_url)

    .catch(error => console.error('Error fetching media data:', error));

    return null;

}
