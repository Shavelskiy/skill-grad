const dropdown = document.querySelector('.header-dropdown')

if (dropdown) {
  const openDropdownBtns = document.querySelectorAll('.open-header-dropdown-btn')

  openDropdownBtns.forEach((button) => {
    button.addEventListener('click', () => {
      dropdown.classList.toggle('active')
    })
  })

  window.addEventListener('click', (event) => {
    let needCheck = true;
    openDropdownBtns.forEach((button) => {
      if (event.target === button) {
        needCheck = false
      }
    })

    if (!needCheck) {
      return
    }

    if (!dropdown.contains(event.target)) {
      dropdown.classList.remove('active')
    }
  })
}
