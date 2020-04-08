import './scss/index.scss';

let coll = document.getElementsByClassName('collapsible');
for (let i = 0; i < coll.length; i++) {
  coll[i].addEventListener('click', function () {
    this.classList.toggle('active');
    let content = this.nextElementSibling;
    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + 'px';
    }
  });
}

let sidebarToggler = document.querySelector('.sidebar-toggler');
sidebarToggler.addEventListener('click', function () {
  this.classList.toggle('sidebar-toggler--active');
  let content = document.getElementsByClassName('main')[0];
  content.classList.toggle('main--active');
});

const userProfileButton = document.querySelector('.user-profile');
const userProfileMenu = document.querySelector('.user-profile-card');

const userProfileButtonDom = document.querySelector('.user-profile');
const userProfileMenuDom = document.querySelector('.user-profile-card');

userProfileButton.addEventListener('click', function () {
  userProfileMenu.classList.toggle('user-profile-card-hidden');
});

document.addEventListener('click', function (event) {
  if (!userProfileMenuDom.contains(event.target) && !userProfileButtonDom.contains(event.target)) {
    userProfileMenu.classList.add('user-profile-card-hidden');
  }
})
