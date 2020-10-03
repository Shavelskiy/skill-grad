import './price-range'

const programFilter = document.querySelector('.program-filter')

if (programFilter !== null) {
  const practiceInput = document.querySelector('.program-filter .practice-container input')

  practiceInput.onchange = (event) => {
    const value = Number(event.target.value)

    if (value > 100) {
      practiceInput.value = 100
    }

    if (value < 0) {
      practiceInput.value = 0
    }
  }

  const mobileFilterToggle = document.getElementById('open-mobile-filter')
  const mobileFilterToggleIcon = mobileFilterToggle.querySelector('i')

  mobileFilterToggle.onclick = () => {
    if (programFilter.classList.contains('active')) {
      programFilter.classList.remove('active')
      mobileFilterToggleIcon.classList.remove('icon-no-entry')
      mobileFilterToggleIcon.classList.add('icon-more')
    } else {
      programFilter.classList.add('active')
      mobileFilterToggleIcon.classList.remove('icon-more')
      mobileFilterToggleIcon.classList.add('icon-no-entry')
    }
  }
}
