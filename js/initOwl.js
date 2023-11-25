
/*Init OWL par defaut */


$(document).ready(function() {
  
    $(document).on('galleryCreated', function () {
      


        $('.owl-carousel').owlCarousel({
            loop: true,
            /* autoplay: true,
            autoplayTimeout: 3000, */
            margin:5,
            responsiveClass:true,
            responsive: {
                
                0:{
                    items:1,
                    loop: true,
                    nav: true
                },
                500: {
                    items:2,
                    nav: true,
                    loop:true
                },
                750:{
                    items:3,
                    nav: true,
                    loop:true
                },
                1350:{
                    items: 8,
                    
                    nav:true,
                    loop:true
                }
            }
        })
    
    });

    setTimeout(function () {
        
        const divOwl = document.querySelector(".owl-carousel.owl-theme.owl-loaded.owl-drag");
        if (!divOwl) {

            location.reload();
            //console.log('reload');

        }


    }, 500);





});

