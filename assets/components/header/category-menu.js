import { initModal } from '@/components/modal'

const categoryMenuBtn = document.querySelector('.categories-menu-btn')
const categoryMenu = document.querySelector('.categories-menu')
const mobileCategoryMenuModal = document.getElementById('mobile-categories')

initModal(mobileCategoryMenuModal)

categoryMenuBtn.addEventListener('click', (event) => {
  if (categoryMenu.contains(event.target)) {
    return
  }

  if (window.innerWidth > 768) {
    categoryMenu.classList.toggle('active')
  } else {
    mobileCategoryMenuModal.classList.add('active')
  }
})

window.addEventListener('click', (event) => {
  if (categoryMenuBtn.contains(event.target)) {
    return
  }

  if (!categoryMenu.contains(event.target)) {
    categoryMenu.classList.remove('active')
  }
})

const mobileMainMenuContainer = document.querySelector('.mobile-main-container')
const backButton = document.querySelector('.arrow-back')

document.querySelectorAll('.open-mobile-subcategory').forEach(button => {
  button.onclick = () => {
    document.querySelector(`.mobile-menu-subcategory[data-subscategory-id='${button.dataset.subscategoryId}']`).classList.add('active')
    mobileMainMenuContainer.classList.remove('active')
    backButton.classList.add('active')
  }
})

backButton.onclick = () => {
  mobileMainMenuContainer.classList.add('active')
  backButton.classList.remove('active')

  document.querySelectorAll('.mobile-menu-subcategory').forEach(element => {
    element.classList.remove('active')
  })
}
