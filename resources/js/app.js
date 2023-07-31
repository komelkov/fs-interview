import "./bootstrap";

import Alpine from "alpinejs";
import Glide from "@glidejs/glide";

window.Alpine = Alpine;

Alpine.start();

const config = {
    type: "carousel",
    startAt: 0,
    perView: 4,
    gap: 32,
    perView: 1,
};
const carousels = document.querySelectorAll(".glide");
carousels.forEach((carousel) => {
    new Glide(carousel, config).mount();
});
