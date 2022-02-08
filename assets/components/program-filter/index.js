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
}
