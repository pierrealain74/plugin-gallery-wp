const postsUrl = `${window.location.origin}/wp-json/wp/v2/posts?_fields=id,title,categories,featured_media,&per_page=20`;

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

  createCarousel(postsData);
  
  /********************/
  
})
.catch(error => {
  console.error('Fetch error:', error);
});



async function createCarousel(postsData) {

const banner = document.getElementById('banner');
const bannerImg = document.querySelector('.banner-img');
const arrowLeft = document.querySelector('.arrow_left');
const arrowRight = document.querySelector('.arrow_right');


  // Récupérer les éléments du DOM
  /*   const bannerImg = document.querySelector('.banner-img'); */

  const title = document.querySelector('.title');
  title.textContent = postsData[0].title.rendered;

  const categoriesElt = document.querySelector('.categories');  
  let categorie = await fetchCategories(postsData[0].categories)
  categoriesElt.textContent = categorie.join(', ');
  //console.log('categories : ', categorie);

  //console.log('1st url : ', postsData[0].featured_media);
  let thumbnailId = postsData[0].featured_media
  let firstUrl = await fetchMedia(thumbnailId);
  //console.log('firstUrl : ', firstUrl);

  const sliderImg = document.createElement("img");
  sliderImg.classList.add('banner-img');
  sliderImg.src = firstUrl;

  banner.appendChild(sliderImg);


  let currentSlide = 0;
  let direction;

  async function modifySlide() {
    
    console.log('currentSlide : ', currentSlide);

      
    /*Title */
    title.textContent = postsData[currentSlide].title.rendered;

    /**Categorie */
    let categorie = await fetchCategories(postsData[currentSlide].categories)
    categoriesElt.textContent = categorie.join(', ');

    /**Image */
    let thumbnailId = postsData[currentSlide].featured_media
    let nextUrl = await fetchMedia(thumbnailId);

    sliderImg.classList.remove('animate_slider');
    void sliderImg.offsetWidth;
    sliderImg.classList.add('animate_slider');

    sliderImg.src = nextUrl;   


  }

  //console.log('currentSlide : ', currentSlide);

  arrowRight.addEventListener(
    'click', () => {

      currentSlide++;

      if (currentSlide >= postsData.length) {//si on arrive au dernier slide
          currentSlide = 0;
      }
      modifySlide();

    }
  );

  arrowLeft.addEventListener(
    'click', () => {
      
      currentSlide--;

      if (currentSlide <  0) {//si on arrive au dernier slide
          currentSlide = postsData.length-1;
      }
      modifySlide();

    }
  );

}//fin de fonction createCarousel


  function fetchMedia(thumbnailId){

    const urLocation = window.location.origin;

    return fetch(`${urLocation}/wp-json/wp/v2/media/${thumbnailId}`)

    .then(response => response.json())

    .then(thumbnail => thumbnail.source_url)

    .catch(error => console.error('Error fetching media data:', error));

    return null;

}

function fetchCategories(catId) {
  const urLocation = window.location.origin;

  // Utilisation de Promise.all pour gérer plusieurs requêtes en parallèle
  const categoryPromises = catId.map(id =>
    fetch(`${urLocation}/wp-json/wp/v2/categories/${id}`)
      .then(response => response.json())
      .then(category => category.name)
  );

  return Promise.all(categoryPromises)
    .catch(error => console.error('Error fetching categories:', error));
}
