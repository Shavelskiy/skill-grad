const categoryMenuBtn = document.querySelector('.categories-menu-btn')
const categoryMenu = document.querySelector('.categories-menu')

categoryMenuBtn.addEventListener('click', () => {
  categoryMenu.classList.toggle('active')
})

window.addEventListener('click', (event) => {
  if (event.target === categoryMenuBtn) {
    return
  }

  if (!categoryMenu.contains(event.target)) {
    categoryMenu.classList.remove('active')
  }
})
