document.querySelectorAll('.custom-select').forEach(item => {
  const selectedOption = item.querySelector('.selected-option')

  if (!selectedOption) {
    return
  }

  const input = item.querySelector('input')
  const form = document.getElementById(item.dataset.formId)
  const placeholder = item.dataset.placeholder

  const selectedOptionValue = selectedOption.querySelector('.selected-option-value')
  const optionsContainer = item.querySelector('.options-container')

  window.addEventListener('click', (event) => {
    if (event.target !== selectedOption && !optionsContainer.contains(event.target)) {
      item.classList.remove('opened')
    }
  })

  selectedOption.onclick = () => {
    if (item.classList.contains('disabled')) {
      return
    }

    if (item.classList.contains('opened')) {
      item.classList.remove('opened')
    } else {
      item.classList.add('opened')
    }
  }


  const initSelect = () => {
    let selectedOption = null
    optionsContainer.querySelectorAll('.option').forEach(option => {
      if (option.classList.contains('active')) {
        selectedOption = option
      }
    })

    selectedOptionValue.innerHTML = (selectedOption !== null) ? selectedOption.innerHTML : placeholder
    input.value = (selectedOption !== null) ? selectedOption.dataset.value : ''
  }

  initSelect()

  optionsContainer.querySelectorAll('.option').forEach(option => {
    option.onclick = () => {
      const uncheck = option.classList.contains('active')

      unsetOptions()

      if (uncheck) {
        selectedOptionValue.innerHTML = placeholder
        input.value = ''
      } else {
        selectedOptionValue.innerHTML = option.innerHTML
        input.value = option.dataset.value
        option.classList.add('active')
      }

      item.classList.remove('opened')

      if (form) {
        form.submit()
      }
    }
  })

  const unsetOptions = () => {
    optionsContainer.querySelectorAll('.option').forEach(option => {
      option.classList.remove('active')
    })
  }
})
