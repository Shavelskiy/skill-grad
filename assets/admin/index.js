import App from './components/app';
import ReactDOM from 'react-dom';
import React from 'react';

ReactDOM.render(
  <App />,
  document.getElementById('root')
);


//
// const userProfileButton = document.querySelector('.user-profile');
// const userProfileMenu = document.querySelector('.user-profile-card');
//
// const userProfileButtonDom = document.querySelector('.user-profile');
// const userProfileMenuDom = document.querySelector('.user-profile-card');
//
// userProfileButton.addEventListener('click', function () {
//   userProfileMenu.classList.toggle('user-profile-card-hidden');
// });
//
// document.addEventListener('click', function (event) {
//   if (!userProfileMenuDom.contains(event.target) && !userProfileButtonDom.contains(event.target)) {
//     userProfileMenu.classList.add('user-profile-card-hidden');
//   }
// })
