const postsUrl = `${window.location.origin}/wp-json/wp/v2/posts?_fields=id,title,featured_media,&per_page=20`;

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
  const siteMain = document.querySelector('.site-main');
  /*   const bannerImg = document.querySelector('.banner-img'); */

  const pDots = document.querySelector('.dots');

  //console.log('1st url : ', postsData[0].featured_media);
  let thumbnailId = postsData[0].featured_media
  let firstUrl = await fetchMedia(thumbnailId);
  //console.log('firstUrl : ', firstUrl);

  const sliderImg = document.createElement("img");
  sliderImg.classList.add('banner-img');
  sliderImg.src = firstUrl;

  siteMain.appendChild(sliderImg);





  async function modifySlide() {
    
    console.log('currentSlide : ', currentSlide);

    let thumbnailId = postsData[currentSlide].featured_media
    let nextUrl = await fetchMedia(thumbnailId);

    sliderImg.src = nextUrl;



  }

  let currentSlide = 0;
  console.log('currentSlide : ', currentSlide);

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