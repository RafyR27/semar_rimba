import Swiper from "swiper";
import { Autoplay, EffectFade, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/effect-fade";
import { Editor } from "@tiptap/core";
import StarterKit from "@tiptap/starter-kit";

window.createTiptapAlpineData = function (initialContent = "") {
    let editor = null;

    return {
        content: initialContent,
        tick: 0,

        init() {
            editor = new Editor({
                element: this.$refs.editor,
                extensions: [StarterKit],
                content: this.content || "",
                editorProps: {
                    attributes: {
                        class: "tiptap-prose min-h-[180px] px-3.5 py-3 text-sm text-zinc-900 dark:text-zinc-100 focus:outline-none",
                    },
                },
                onUpdate: ({ editor: instance }) => {
                    this.content = instance.isEmpty ? "" : instance.getHTML();
                    this.tick++;
                },
                onSelectionUpdate: () => {
                    this.tick++;
                },
                onTransaction: () => {
                    this.tick++;
                },
            });
        },

        destroy() {
            if (editor) {
                editor.destroy();
                editor = null;
            }
        },

        isActive(name, attrs = {}) {
            void this.tick;
            return editor ? editor.isActive(name, attrs) : false;
        },

        toggleBold() {
            editor?.chain().focus().toggleBold().run();
        },
        toggleItalic() {
            editor?.chain().focus().toggleItalic().run();
        },
        toggleStrike() {
            editor?.chain().focus().toggleStrike().run();
        },
        toggleHeading(level) {
            editor?.chain().focus().toggleHeading({ level }).run();
        },
        toggleBulletList() {
            editor?.chain().focus().toggleBulletList().run();
        },
        toggleOrderedList() {
            editor?.chain().focus().toggleOrderedList().run();
        },
        toggleBlockquote() {
            editor?.chain().focus().toggleBlockquote().run();
        },
        undo() {
            editor?.chain().focus().undo().run();
        },
        redo() {
            editor?.chain().focus().redo().run();
        },
    };
};

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
