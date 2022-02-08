import './scss/faq.scss'

import { insertParam } from '@/helpers/location-helper'


const menuItems = document.querySelectorAll('.faq-menu-item')
const contentItems = document.querySelectorAll('.faq-content-item')

menuItems.forEach(menuItem => {
  menuItem.onclick = () => {
    if (menuItem.classList.contains('active')) {
      return
    }

    menuItems.forEach(selectedMenuItem => {
      if (selectedMenuItem.classList.contains('active')) {
        selectedMenuItem.classList.remove('active')
      }
    })

    contentItems.forEach(selectedContentItem => {
      if (selectedContentItem.classList.contains('active')) {
        selectedContentItem.classList.remove('active')
      }

      if (selectedContentItem.dataset.id === menuItem.dataset.id) {
        selectedContentItem.classList.add('active')
      }
    })

    menuItem.classList.add('active')

    insertParam('id', menuItem.dataset.id)
  }
})
