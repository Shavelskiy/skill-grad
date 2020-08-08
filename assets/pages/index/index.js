import 'swiper/swiper.scss'
import Swiper from 'swiper'
import showRegisterForm from '../../components/modal/choose-role-modal'
import { ROLE_PROVIDER, ROLE_USER } from '../../utils/user-roles'
import './index.scss'

const initTabs = (navSelector, contentSelector) => {
  const tabNav = document.querySelectorAll(navSelector)
  const tabContent = document.querySelectorAll(contentSelector)

  tabNav.forEach(item => {
    item.addEventListener('click', (event) => handleTabClick(event, tabNav, tabContent))
  })
}

const handleTabClick = (event, tabNav, tabContent) => {
  tabNav.forEach(item => {
    item.classList.remove('active')
  })

  event.target.classList.add('active')

  selectTabContent(event.target.getAttribute('data-tab-name'), tabContent)
}

const selectTabContent = (tabName, tabContent) => {
  tabContent.forEach(item => {
    item.classList.contains(tabName) ? item.classList.add('active') : item.classList.remove('active')
  })
}

initTabs('.study-tabs-nav .nav-item', '.study-content-items .tab__content-item')
// initTabs('.study-content__item-circle', '.study-tab-content')
// // initTabs('.how-work__info-mobile .how-work__info-title', '.how-work__info')

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
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  })
})

