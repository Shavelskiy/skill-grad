import 'swiper/swiper.scss'
import Swiper from 'swiper'
import showRegisterForm from '../components/modal/choose-role-modal'
import { ROLE_PROVIDER, ROLE_USER } from '../utils/user-roles'


const initTabs = (navSelector, contentSelector) => {
  const tabContent = document.querySelectorAll(contentSelector)
  const tabNav = document.querySelectorAll(navSelector)

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

initTabs('.tabs-nav__item', '.study-content__item')
initTabs('.study-content__item-circle', '.study-content__item')
initTabs('.how-work__info-mobile .how-work__info-title', '.how-work__info')

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
