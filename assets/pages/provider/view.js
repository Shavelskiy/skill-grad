import { feedbackModal } from '@/components/modal'
import { insertParam } from '@/helpers/location-helper'
import './view.scss'

document.addEventListener('keydown', function (event) {
  if (event.ctrlKey && event.key === 'Enter') {
    feedbackModal.classList.add('active')
  }
})

const tabDescription = document.querySelector('.tab-description')
const tabProgram = document.querySelector('.tab-programs')
const tabGallery = document.querySelector('.tab-gallery')

const navDescription = document.querySelector('.nav-item-description')
const navProgram = document.querySelector('.nav-item-programs')
const navGallery = document.querySelector('.nav-item-gallery')

const initNavClick = (nav) => {
  nav.onclick = () => {
    if (nav.classList.contains('active')) {
      return
    }

    switch (nav) {
      case navDescription:
        insertParam('tab', 'description')
        navProgram.classList.remove('active')
        navGallery.classList.remove('active')

        tabProgram.classList.remove('active')
        tabGallery.classList.remove('active')

        tabDescription.classList.add('active')

        break
      case navProgram:
        insertParam('tab', 'programs')
        navDescription.classList.remove('active')
        navGallery.classList.remove('active')

        tabDescription.classList.remove('active')
        tabGallery.classList.remove('active')

        tabProgram.classList.add('active')

        break
      case navGallery:
        insertParam('tab', 'gallery')
        navDescription.classList.remove('active')
        navProgram.classList.remove('active')

        tabDescription.classList.remove('active')
        tabProgram.classList.remove('active')

        tabGallery.classList.add('active')

        break
    }

    nav.classList.add('active')
  }
}

initNavClick(navDescription)
initNavClick(navProgram)
initNavClick(navGallery)
