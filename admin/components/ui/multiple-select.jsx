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

  const selectValue = (item) => {
    if (values.includes(item.value)) {
      setValue(values.filter(value => {
        return item.value !== value
      }))
    } else {
      setValue([...values, item.value])
    }
  }

  const getTitle = () => {
    let selectedValues = []
    options.forEach(item => {
      if (values.includes(item.value)) {
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
            onClick={() => selectValue(item)}
          />
        </span>
      )
    })
  }

  const handleTitleClick = (event) => {
    if (event.target.classList.contains(css.close)) {
      return
    }

    setOpened(!opened)
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
        <ul>
          {
            options.map((item, key) => {
              return (
                <li
                  key={key}
                  className={cn({[css.active]: values.includes(item.value)})}
                  onClick={() => selectValue(item)}>
                  {item.title}
                </li>
              )
            })
          }
        </ul>
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
