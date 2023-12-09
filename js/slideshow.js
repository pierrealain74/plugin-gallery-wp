//Creer un tableau  des post : title, thumbnail full, cat



createCarousel(all_posts_json);


async function createCarousel(postsData) {

const banner = document.getElementById('banner');
const bannerImg = document.querySelector('.banner-img');
const arrowLeft = document.querySelector('.arrow_left');
const arrowRight = document.querySelector('.arrow_right');


  // Récupérer les éléments du DOM
  /*   const bannerImg = document.querySelector('.banner-img'); */

  const title = document.querySelector('.title');
  title.textContent = postsData[0].title;

  const categoriesElt = document.querySelector('.categories');  
  let categoryTab = postsData[0].category;
  categoriesElt.textContent = categoryTab.join(', ');
  //console.log('categories : ', categorie);

  //console.log('1st url : ', postsData[0].featured_media);
  let thumbnail = postsData[0].thumbnail;
  //console.log('firstUrl : ', firstUrl);

  const sliderImg = document.createElement("img");
  sliderImg.classList.add('banner-img');
  sliderImg.src = thumbnail;

  banner.appendChild(sliderImg);


  let currentSlide = 0;
  let direction;

  async function modifySlide() {
    
    console.log('currentSlide : ', currentSlide);

      
    /*Title */
    title.textContent = postsData[currentSlide].title;

    /**Categorie */
    let categoryTab = postsData[currentSlide].category
    categoriesElt.textContent = categoryTab.join(', ');

    /**Image */
    let thumbnail = postsData[currentSlide].thumbnail;

    sliderImg.classList.remove('animate_slider');
    void sliderImg.offsetWidth;
    sliderImg.classList.add('animate_slider');

    sliderImg.src = thumbnail;   


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

