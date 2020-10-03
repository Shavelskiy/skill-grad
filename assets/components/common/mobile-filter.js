const formWithMobile = document.querySelector('.form-with-mobile')

if (formWithMobile !== null) {
  const mobileFilterToggle = document.getElementById('open-mobile-filter')
  const mobileFilterToggleIcon = mobileFilterToggle.querySelector('i')

  mobileFilterToggle.onclick = () => {
    if (formWithMobile.classList.contains('active')) {
      formWithMobile.classList.remove('active')
      mobileFilterToggleIcon.classList.remove('icon-no-entry')
      mobileFilterToggleIcon.classList.add('icon-more')
    } else {
      formWithMobile.classList.add('active')
      mobileFilterToggleIcon.classList.remove('icon-more')
      mobileFilterToggleIcon.classList.add('icon-no-entry')
    }
  }
}
