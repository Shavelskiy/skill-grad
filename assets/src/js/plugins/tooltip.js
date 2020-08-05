export class Tooltip {
  constructor(options = {}) {
   this.$elements = document.querySelectorAll('[data-type="tooltip"]');
   this.options = options;
   this.createElement = '';
   this.setup();
  }
  render(target) {
    const {text} = target.dataset;
    this.createElement = document.createElement('div');
    this.createElement.textContent = text;
    this.createElement.classList.add('t');
    if(this.options.classes) this.createElement.classList.add(this.options.classes);
    document.body.append(this.createElement);
    this.position(target);
  }
  position(target) {
    let coords = target.getBoundingClientRect();
    let left = coords.left + (target.offsetWidth - this.createElement.offsetWidth) / 2;
    if (left < 0) left = 0;
    let top = coords.top - this.createElement.offsetHeight - 5;
    if (top < 0) {
      top = coords.top + target.offsetHeight + 5;
    }
    this.createElement.style.top = coords.y + coords.top + 'px';
    this.createElement.style.left = left + 'px';
  }
  setup() {
    this.onMouseOverHandler = this.onMouseOverHandler.bind(this);
    this.onMouseOutHandler = this.onMouseOutHandler.bind(this);
    this.$elements.forEach(el => {
      el.addEventListener('mouseover', this.onMouseOverHandler);
      el.addEventListener('mouseout', this.onMouseOutHandler);
    });
  }
  onMouseOverHandler(event) {
    const target = event.target;
    console.log(target.getBoundingClientRect());
    this.render(target);
  }
  onMouseOutHandler(event) {
    this.createElement.remove();
  }
}
