export class Slider {
  constructor(el) {
    this.$el = document.querySelector(el);
    if (this.$el) {
      this.$slides = this.$el.querySelectorAll('.item');
      this.$cSlide = this.$el.querySelector('.current-slide');
      this.numSlides = this.$slides.length;
      this.slideIndex = 1;
      this.render();
      this.showSlides(this.slideIndex);
      this.setup();
    }
  }

  render() {
    this.$cSlide.querySelector('.all').textContent = this.numSlides;
    this.$cSlide.querySelector('.current').textContent = this.slideIndex;
  }

  setup() {
    this.clickHandler = this.clickHandler.bind(this);
    this.$el.addEventListener('click', this.clickHandler);
  }

  clickHandler(event) {
    const {type} = event.target.dataset;
    if (type === 'previous') {
      this.showSlides(this.slideIndex -= 1);
    } else if (type === 'next') {
      this.showSlides(this.slideIndex += 1);
    }
  }

  showSlides(n) {
    if (n > this.numSlides) {
      this.slideIndex = 1;
    }
    if (n < 1) {
      this.slideIndex = this.numSlides;
    }
    for (let slide of this.$slides) {
      slide.style.display = 'none';
    }
    this.$slides[this.slideIndex - 1].style.display = 'block';
    this.render();
  }
}
