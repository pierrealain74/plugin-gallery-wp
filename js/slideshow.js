//Creer un tableau  des post : title, thumbnail full, cat



createCarousel(all_posts_json);


function createCarousel(postsData) {

  /**Afficher le 1er POST */

  let currentSlide = 0;

  const banner = document.getElementById('banner');
  const arrowLeft = document.querySelector('.arrow_left');
  const arrowRight = document.querySelector('.arrow_right');
  const pDots = document.querySelector('.dots');


  const title = document.querySelector('.title');
  title.textContent = postsData[0].title;

  const categoriesElt = document.querySelector('.categories');
  let categoryTab = postsData[0].category;
  categoriesElt.textContent = categoryTab.join(', ');
  //console.log('categories : ', categorie);

  //console.log('1st url : ', postsData[0].featured_media);
  let thumbnail = postsData[0].thumbnail;
  //console.log('firstUrl : ', firstUrl);

  const imgElt = document.createElement("img");
  imgElt.classList.add('banner-img');
  imgElt.src = thumbnail;

  banner.appendChild(imgElt);

  /**Afficher les DOTS*/

  // Créer un point pour chaque slide
  postsData.forEach((slide, index) => {
    

    const dot = document.createElement('span');
    dot.setAttribute('data-index', index);      
    dot.classList.add('dot');
    if (index === 0) {
      dot.classList.add('dot_selected');
    }
    dot.addEventListener('click', (event) => {
    const clickedDotIndex = event.target.getAttribute('data-index');// récupère le n° index 
    currentSlide = clickedDotIndex;
    
    modifySlide();
  
  
    }); 
  
    // Ajoute dynamiquement chaque point
    pDots.appendChild(dot);
  
  });//endforeach


  function modifySlide() {
    
    console.log('currentSlide : ', currentSlide);

      
    /*Title */
    title.textContent = postsData[currentSlide].title;

    /**Categorie */
    let categoryTab = postsData[currentSlide].category
    categoriesElt.textContent = categoryTab.join(', ');

    /**Image */
    let thumbnail = postsData[currentSlide].thumbnail;

    imgElt.classList.remove('animate_slider');
    void imgElt.offsetWidth;
    imgElt.classList.add('animate_slider');

    imgElt.src = thumbnail;   

    /**Ajouter le dot_selected sur le dot actif et supprimer tous les autres */

    const allDots = document.querySelectorAll('.dots span');
    allDots.forEach(dots => dots.classList.remove('dot_selected'));

    const dotSelected = document.querySelector('.dots span[data-index = "' + currentSlide + '"]');
    dotSelected.classList.add('dot_selected');

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
