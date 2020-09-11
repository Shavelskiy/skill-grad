const categoryMenuBtn = document.querySelector('.categories-menu-btn')
const categoryMenu = document.querySelector('.categories-menu')

categoryMenuBtn.addEventListener('click', (event) => {
  if (categoryMenu.contains(event.target)) {
    return
  }

  categoryMenu.classList.toggle('active')
})

window.addEventListener('click', (event) => {
  if (categoryMenuBtn.contains(event.target)) {
    return
  }

  if (!categoryMenu.contains(event.target)) {
    categoryMenu.classList.remove('active')
  }
})
