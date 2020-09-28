import React, { useEffect, useRef, useState } from 'react'

import css from './scss/select.scss?module'
import cn from 'classnames'


const Select = ({options, value, setValue, placeholder = ''}) => {
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
    if (value !== null && value === item.value) {
      setValue(null)
    } else {
      setValue(item.value)
    }

    setOpened(false)
  }

  const handleTitleClick = () => {
    if (options.length < 1) {
      return
    }

    setOpened(!opened)
  }

  const getTitle = () => {
    const selectedItems = options.filter((item) => {
      return item.value === value
    })

    return selectedItems.length > 0 ? selectedItems[0].title : placeholder
  }

  return (
    <div ref={ref} className={
      cn(
        css.customSelect,
        {[css.disabled]: options.length < 1},
        {[css.opened]: opened},
      )}
    >
      <div
        className={css.selectedOption}
        onClick={handleTitleClick}
      >
        <span> {getTitle()}</span>
        <span className={css.icon}></span>
      </div>
      <div className={css.optionsContainer}>
        <div className={css.options}>
          {
            options.map((item, key) => {
              return (
                <div
                  key={key}
                  className={cn(css.option, {[css.active]: (item.value === value)})}
                  onClick={() => selectValue(item)}
                >
                  {item.title}
                </div>
              )
            })
          }
        </div>
      </div>
    </div>
  )
}

export default Select
