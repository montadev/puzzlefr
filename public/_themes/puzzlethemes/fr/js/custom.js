document.addEventListener('DOMContentLoaded', function() {
  const slides = document.querySelectorAll('.slide');
  const dots = document.querySelectorAll('.dot');
  const prevButton = document.querySelector('.prev');
  const nextButton = document.querySelector('.next');
  let currentSlide = 0;
  let intervalId;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      if (i === index) {
        slide.classList.add('active');
      } else {
        slide.classList.remove('active');
      }
    });
  }

  function activateDot(index) {
    dots.forEach((dot, i) => {
      if (i === index) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  function nextSlide() {
    currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1;
    showSlide(currentSlide);
    activateDot(currentSlide);
  }

  function startInterval() {
    intervalId = setInterval(nextSlide, 5000);
  }

  function goToSlide(index) {
    currentSlide = index;
    showSlide(currentSlide);
    activateDot(currentSlide);
    clearInterval(intervalId);
    startInterval();
  }

  startInterval();
  showSlide(0);
  activateDot(0);

  if (prevButton) {
    prevButton.addEventListener('click', () => {
      currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1;
      showSlide(currentSlide);
      activateDot(currentSlide);
      clearInterval(intervalId);
      startInterval();
    });
  }

  if (nextButton) {
    nextButton.addEventListener('click', () => {
      nextSlide();
      clearInterval(intervalId);
      startInterval();
    });
  }

  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
      goToSlide(index);
    });
  });
});
