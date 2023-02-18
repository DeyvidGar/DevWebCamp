// import Swiper JS
import Swiper, { Navigation } from 'swiper';
// import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector('.slider')) {
        const opciones = {
            slidesPerView: 1,
            spaceBetween: 18,
            freeMode: true,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // MediaQuerys
            breakpoints:{
                769: {
                    slidesPerView: 2
                },
                969: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        };

        Swiper.use([Navigation])
        new Swiper('.slider', opciones)
    }
})