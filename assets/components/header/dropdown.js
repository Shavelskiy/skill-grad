const dropdown = document.querySelector('.header-dropdown')

if (dropdown) {
  const openDropdownButtons = document.querySelectorAll('.open-header-dropdown-btn')

  openDropdownButtons.forEach((button) => {
    button.addEventListener('click', () => {
      dropdown.classList.toggle('active')
    })
  })

  window.addEventListener('click', (event) => {
    let needCheck = true;
    openDropdownButtons.forEach((button) => {
      if (button.contains(event.target)) {
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
