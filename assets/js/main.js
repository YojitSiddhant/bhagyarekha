(() => {
  const btn = document.querySelector(".menu-toggle");
  const nav = document.querySelector("#mainNav");
  if (!btn || !nav) return;

  btn.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("active");
    btn.setAttribute("aria-expanded", isOpen ? "true" : "false");
  });
})();

(() => {
  const slider = document.querySelector(".home-slider");
  if (!slider) return;

  const slides = Array.from(slider.querySelectorAll(".home-slide"));
  if (slides.length <= 1) return;

  let index = 0;
  const intervalMs = Number.parseInt(slider.dataset.interval || "4500", 10);
  const prevBtn = slider.querySelector(".home-slider-btn.prev");
  const nextBtn = slider.querySelector(".home-slider-btn.next");
  const dots = Array.from(slider.querySelectorAll(".home-slider-dot"));

  const show = (i) => {
    slides.forEach((s, n) => s.classList.toggle("is-active", n === i));
    dots.forEach((d, n) => d.classList.toggle("is-active", n === i));
  };

  const prev = () => {
    index = (index - 1 + slides.length) % slides.length;
    show(index);
  };

  const next = () => {
    index = (index + 1) % slides.length;
    show(index);
  };

  let timer = window.setInterval(next, intervalMs);
  const resetTimer = () => {
    window.clearInterval(timer);
    timer = window.setInterval(next, intervalMs);
  };

  slider.addEventListener("mouseenter", () => {
    window.clearInterval(timer);
  });
  slider.addEventListener("mouseleave", () => {
    timer = window.setInterval(next, intervalMs);
  });

  prevBtn?.addEventListener("click", () => {
    prev();
    resetTimer();
  });
  nextBtn?.addEventListener("click", () => {
    next();
    resetTimer();
  });

  dots.forEach((dot, i) => {
    dot.addEventListener("click", () => {
      index = i;
      show(index);
      resetTimer();
    });
  });
})();

(() => {
  const popup = document.querySelector("#leadPopup");
  if (!popup) return;

  const closeBtn = popup.querySelector(".popup-close");

  const openPopup = () => {
    popup.classList.add("is-open");
    popup.setAttribute("aria-hidden", "false");
  };

  const closePopup = () => {
    popup.classList.remove("is-open");
    popup.setAttribute("aria-hidden", "true");
  };

  window.setTimeout(openPopup, 1200);

  closeBtn?.addEventListener("click", closePopup);
  popup.addEventListener("click", (e) => {
    if (e.target === popup) closePopup();
  });
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closePopup();
  });
})();

