import React, { useEffect, useRef, useState } from 'react'

import css from './select.scss?module'

import cn from 'classnames'

import arrow from './../../images/select-arrow.svg'
import close from './../../images/close.svg'


const MultipleSelect = ({label, options, values, setValue, isForm = true, small = false, medium = false, large = false, high = true}) => {
  const ref = useRef()
  const [opened, setOpened] = useState(false)

  useEffect(() => {
    const listener = event => {
      if (!ref.current || ref.current.contains(event.target)) {
        return
      }

      setOpened(false)
    }

    document.addEventListener('mousedown', listener)

    return () => {
      document.removeEventListener('mousedown', listener)
    }
  }, [ref, setOpened])

  const handleTitleClick = (event) => {
    if (event.target.classList.contains(css.close)) {
      return
    }

    setOpened(!opened)
  }

  const getTitle = () => {
    let selectedValues = []
    options.forEach(item => {
      if (values && values.includes(item.value)) {
        selectedValues.push(item)
      }
    })

    return selectedValues.map((item, key) => {
      return (
        <span key={key} className={css.selectedMultiOption}>
          {item.title}
          <img
            src={close}
            className={css.close}
            onClick={() => setValue(values.filter(value => item.value !== value))}
          />
        </span>
      )
    })
  }

  const getOptions = () => {
    const availableOptions = options.filter(item => {
      return !values || !values.includes(item.value)
    })

    if (availableOptions.length < 1) {
      return <li>Нет вариантов</li>
    }

    return availableOptions.map((item, key) => {
      return (
        <li key={key} onClick={() => setValue([...values, item.value])}>
          {item.title}
        </li>
      )
    })
  }

  const content = (
    <div ref={ref} className={
      cn(
        css.select,
        css.multiple,
        {[css.opened]: opened},
        {[css.small]: small},
        {[css.medium]: medium},
        {[css.large]: large},
        {[css.high]: high},
      )}
    >
      <div className={css.selectedOption} onClick={handleTitleClick}>
        {getTitle()}
        <img src={arrow} className={css.icon}/>
      </div>
      <div className={css.optionContainer}>
        <ul>{getOptions()}</ul>
      </div>
    </div>
  )

  if (!isForm) {
    return content
  }

  return (
    <div className={css.input}>
      <span className={css.label}>{label}</span>
      {content}
    </div>
  )
}

export default MultipleSelect
