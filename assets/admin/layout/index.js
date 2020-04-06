import {library, dom} from '@fortawesome/fontawesome-svg-core';
import {fas} from '@fortawesome/free-solid-svg-icons';
import {far} from '@fortawesome/free-regular-svg-icons';
import {fab} from '@fortawesome/free-brands-svg-icons';

import './index.scss';

library.add(fas, far, fab);

dom.i2svg().then(r => {
});

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

let sidebarToggler = document.getElementsByClassName('sidebar-toggler')[0];
sidebarToggler.addEventListener('click', function () {
  this.classList.toggle('sidebar-toggler--active');
  let content = document.getElementsByClassName('main')[0];
  content.classList.toggle('main--active');
});

// const userProfileButton = $('.user-profile');
// const userProfileMenu = $('.user-profile-card');

const userProfileButtonDom = document.querySelector('.user-profile');
const userProfileMenuDom = document.querySelector('.user-profile-card');


// $(document).ready(function () {
//   userProfileButton.click(function () {
//     userProfileMenu.toggleClass('user-profile-card-hidden');
//   });
//
// });
//
// $(document).click(function (event) {
//   if (!userProfileMenuDom.contains(event.target) && !userProfileButtonDom.contains(event.target)) {
//     userProfileMenu.addClass('user-profile-card-hidden');
//   }
// });
