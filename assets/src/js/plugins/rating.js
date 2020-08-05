export class Rating {
  constructor(el) {
    this.$el = document.getElementById(el);
    if(this.$el) {
      this.$dislike = this.$el.querySelector('[data-type="dislike"]')
        .parentElement
        .querySelector('[data-type="text"]');
      this.$like = this.$el.querySelector('[data-type="like"]')
        .parentElement
        .querySelector('[data-type="text"]');
      this.dislike = 0;
      this.like = 0;
      this.setup();
    }
  }
  setup() {
    this.clickHandler = this.clickHandler.bind(this);
    this.$el.addEventListener('click', this.clickHandler)
  }
  setDislike() {
    this.$dislike.textContent = '' + this.dislike;
  }
  setLike() {
    this.$like.textContent = '' + this.like;
  }
  clickHandler(event) {
    const {type} = event.target.dataset;
    if (type === 'dislike') {
      this.dislike += 1;
      this.setDislike();
    } else if(type === 'like') {
      this.like += 1;
      this.setLike();
    }
  }
}
