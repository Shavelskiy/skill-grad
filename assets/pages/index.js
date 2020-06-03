import 'swiper/swiper.scss'
import Swiper from 'swiper'
import showRegisterForm from '../components/modal/choose-role-modal'
import { ROLE_PROVIDER, ROLE_USER } from '../utils/user-roles'


window.onload = () => {
  initSliders()
  initTabs('.tabs-nav__item')
  initTabs('.study-content__item-circle')
  initHowWorkRegisterBtns()
}

const initSliders = () => {
  const sliders = document.querySelectorAll('.study-slider')

  sliders.forEach((item) => {
    new Swiper(`#${item.id}`, {
      loop: false,
      observer: true,
      observeParents: true,
      slidesPerView: 1,
      breakpoints: {
        575: {
          slidesPerView: 2,
        },
        767: {
          slidesPerView: 3,
        },
      },
    })
  })
}

const initTabs = (selector) => {
  const tabContent = document.querySelectorAll('.study-content__item')
  const tabNav = document.querySelectorAll(selector)

  tabNav.forEach(item => {
    item.addEventListener('click', (event) => handleTabClick(event, tabNav, tabContent))
  })
}

const handleTabClick = (event, tabNav, tabContent) => {
  tabNav.forEach(item => {
    item.classList.remove('is-active')
  })

  event.target.classList.add('is-active')

  selectTabContent(event.target.getAttribute('data-tab-name'), tabContent)
}

const selectTabContent = (tabName, tabContent) => {
  tabContent.forEach(item => {
    item.classList.contains(tabName) ? item.classList.add('is-active') : item.classList.remove('is-active')
  })
}

const initHowWorkRegisterBtns = () => {
  const howWorkRegisterUserBtn = document.querySelector('.how-work-register-user-btn')
  const howWorkRegisterProviderBtn = document.querySelector('.how-work-register-provider-btn')

  howWorkRegisterUserBtn.onclick = () => showRegisterForm(ROLE_USER)
  howWorkRegisterProviderBtn.onclick = () => showRegisterForm(ROLE_PROVIDER)
}


//
// 'use strict';
//
// svg4everybody(); // иницализация полифила для IE
//
// $(document).ready(function () {
//
// });
//
// function myButton() {
//   var x = document.getElementById('mobile__list-mnu');
//   if (x.style.display === 'none') {
//     x.style.display = 'block';
//   } else {
//     x.style.display = 'none';
//   }
// }
//
//
// document.querySelectorAll('.slider__wrapper').forEach(function (item, index) {
//   item.id = 'slider-' + index;
// });
//
//
//
// /* табуляция как работаем */
// let tabHowWork = function () {
//   let tabNav = document.querySelectorAll('.how-work__info-mobile .how-work__info-title'),
//     tabContent = document.querySelectorAll('.how-work__info'),
//     tabName;
//
//   tabNav.forEach(item => {
//     item.addEventListener('click', selectTabNav)
//   });
//
//   function selectTabNav() {
//     tabNav.forEach(item => {
//       item.classList.remove('is-active');
//     });
//     this.classList.add('is-active');
//     tabName = this.getAttribute('data-tab-name');
//     selectTabContent(tabName);
//   }
//
//   function selectTabContent(tabName) {
//     tabContent.forEach(item => {
//       item.classList.contains(tabName) ? item.classList.add('is-active') : item.classList.remove('is-active');
//     })
//   }
//
// };
// /* табуляция как работаем конец */

