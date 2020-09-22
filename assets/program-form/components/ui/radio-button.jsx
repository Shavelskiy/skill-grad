import React from 'react'

import css from './scss/radion-button.scss?module'
import cn from 'classnames'


const RadioButton = ({children, selected = false, checked = false, disabled = false, click}) => {
  const handleClick = () => {
    if (disabled) {
      return
    }

    click()
  }

  return (
    <div className={cn(css.radio, {[css.disabled]: disabled})} onClick={handleClick}>
      <span
        className={cn(
          css.point,
          {[css.selected]: selected},
          {[css.checked]: checked},
        )}
      >
      </span>
      <div className={css.value}>{children}</div>
    </div>
  )
}

export default RadioButton
