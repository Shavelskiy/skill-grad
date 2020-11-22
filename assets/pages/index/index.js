import 'swiper/swiper.scss'
import Swiper from 'swiper'
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

const sliders = document.querySelectorAll('.study-slider')

sliders.forEach((item) => {
  new Swiper(`#${item.id}`, {
    loop: false,
    observer: true,
    observeParents: true,
    slidesPerView: 1,
    breakpoints: {
      600: {
        slidesPerView: 2,
      },
      1000: {
        slidesPerView: 3,
      },
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  })
})

const howWorkStudentButton = document.querySelector('.tab-service__nav.left-block')
const howWorkProviderButton = document.querySelector('.tab-service__nav.right-block')

const howWorkStudentContent = document.querySelector('.tab-service__content.left')
const howWorkProviderContent = document.querySelector('.tab-service__content.right')

howWorkStudentButton.onclick = () => {
  howWorkStudentButton.classList.add('active')
  howWorkProviderButton.classList.remove('active')

  howWorkStudentContent.classList.add('active')
  howWorkProviderContent.classList.remove('active')
}

howWorkProviderButton.onclick = () => {
  howWorkProviderButton.classList.add('active')
  howWorkStudentButton.classList.remove('active')

  howWorkProviderContent.classList.add('active')
  howWorkStudentContent.classList.remove('active')
}
