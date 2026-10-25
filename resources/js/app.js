import Swiper from "swiper";
import { Autoplay, EffectFade, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/effect-fade";

function initHeroSwiper() {
    const heroSwiperEl = document.querySelector(".hero-swiper");
    if (heroSwiperEl && !heroSwiperEl.swiper) {
        new Swiper(heroSwiperEl, {
            modules: [Autoplay, EffectFade],
            effect: "fade",
            fadeEffect: {
                crossFade: true,
            },
            loop: true,
            speed: 1500,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            allowTouchMove: false,
        });
    }
}

let rangkaianSwiper = null;

function initRangkaianSwiper() {
    const el = document.querySelector(".rangkaian-swiper");
    if (!el) return;

    const isMobile = window.innerWidth < 1024;

    if (isMobile) {
        if (!rangkaianSwiper || rangkaianSwiper.destroyed) {
            rangkaianSwiper = new Swiper(el, {
                modules: [Navigation, Pagination],
                slidesPerView: 1.15,
                spaceBetween: 20,
                grabCursor: true,
                speed: 400,
                navigation: {
                    prevEl: ".rangkaian-prev",
                    nextEl: ".rangkaian-next",
                },
                pagination: {
                    el: ".rangkaian-pagination",
                    type: "fraction",
                    formatFractionCurrent: (number) => String(number).padStart(2, "0"),
                    formatFractionTotal: (number) => String(number).padStart(2, "0"),
                    renderFraction: function (currentClass, totalClass) {
                        return `<span class="${currentClass}"></span> / <span class="${totalClass}"></span>`;
                    },
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1.6,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 2.2,
                        spaceBetween: 28,
                    },
                },
            });
        }
    } else {
        if (rangkaianSwiper && !rangkaianSwiper.destroyed) {
            rangkaianSwiper.destroy(true, true);
            rangkaianSwiper = null;
        }
    }
}

function initAllSwipers() {
    initHeroSwiper();
    initRangkaianSwiper();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initAllSwipers);
} else {
    initAllSwipers();
}

window.addEventListener("resize", initRangkaianSwiper);
document.addEventListener("livewire:navigated", initAllSwipers);
