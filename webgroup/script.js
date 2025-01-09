document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector(".slider .list");
    const items = document.querySelectorAll(".slider .list .item");
    let currentIndex = 0;

    function switchImage() {
        currentIndex = (currentIndex + 1) % items.length;
        slider.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    setInterval(switchImage, 1000);
});
