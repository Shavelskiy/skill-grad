import 'swiper/swiper.scss'
import Swiper from 'swiper'
import showRegisterForm from '../../components/modal/choose-role-modal'
import { ROLE_PROVIDER, ROLE_USER } from '../../utils/user-roles'
import './index.scss'


const initTabs = (navSelector, contentSelector) => {
  const tabContent = document.querySelectorAll(contentSelector)
  const tabNav = document.querySelectorAll(navSelector)

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
    console.log(tabName, item)
    item.classList.contains(tabName) ? item.classList.add('active') : item.classList.remove('active')
  })
}

initTabs('.study-tabs-nav-item', '.study-content-item')
initTabs('.study-content__item-circle', '.study-tab-content')
// initTabs('.how-work__info-mobile .how-work__info-title', '.how-work__info')

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

document.querySelector('.how-work-register-user-btn').onclick = () => showRegisterForm(ROLE_USER)
document.querySelector('.how-work-register-provider-btn').onclick = () => showRegisterForm(ROLE_PROVIDER)

document.querySelector('.main__mnu-mobile').onclick = () => {
const mobileMenu = document.getElementById('mobile__list-mnu')

   if (mobileMenu.style.display === 'none') {
     mobileMenu.style.display = 'block'
   } else {
     mobileMenu.style.display = 'none'
   }
   }
