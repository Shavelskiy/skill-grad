import './index.scss';

const modal = document.getElementById('auth-modal');

const btn = document.getElementById('auth-modal-button');


btn.onclick = function () {
  modal.classList.add('active');
};

window.onclick = function (event) {
  console.log(event.target)
  if (event.target === modal) {
    modal.classList.remove('active');
  }
}
