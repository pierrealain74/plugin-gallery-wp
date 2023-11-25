


/* const postsUrl = `${window.location.origin}/wp-json/wp/v2/posts?_fields=id,title,excerpt,date,categories,tags,featured_media,link,&per_page=20&_embed=1`; */

const postsUrl = `${window.location.origin}/wp-json/wp/v2/posts?_fields=id,title,featured_media,&per_page=20`;

console.log(postsUrl);

// Effectuer la requête AJAX avec fetch
fetch(postsUrl)
.then(response => {
    if (!response.ok) {
        throw new Error(`Network response was not ok: ${response.statusText}`);
    }
    return response.json();
})
.then(postsData => {

  /********************/

  //console.log(postsData);

  createOWLCarousel(postsData);
  
  /********************/
  
})
.catch(error => {
    console.error('Fetch error:', error);
});


/**
 * fetchMedia()
 * Fonction de recupération de l'url des thumbnail
 * 
 */
function fetchMedia(urLocation, thumbnailId){

  return fetch(`${urLocation}/wp-json/wp/v2/media/${thumbnailId}`)
          .then(response => response.json())
          .then(mediaData => mediaData.source_url)
          .catch(error => console.error('Error fetching media data:', error));
          return null;
  
  }


  
/**
 * Création de la galerie OWL avec les vignettes des ACF Portfolios.
 * Utilise un fichier JSON pour récupérer les données des vignettes.
 */

function createOWLCarousel(postsData) {

  const container = document.querySelector(".owl-carousel.owl-theme");

  postsData.forEach(async (post) => {


    /**
     * Recupération des Thumbnail
     */

    const thumbnailId = post.featured_media;
    const urLocation = window.location.origin;

    const thumbnailfull = await fetchMedia(urLocation,thumbnailId);

    if (thumbnailfull) {
      //console.log(thumbnailfull);
      

      const divItem = document.createElement("div");
      divItem.classList.add("item");

      const imgItem = document.createElement("img");
      imgItem.src = thumbnailfull;

        divItem.appendChild(imgItem);
        container.appendChild(divItem);

    }

    /**
     * Recupération des title
     */

    /*const title = post.title.rendered
    title ? console.log('title : ', title) : ''*/

  });
}