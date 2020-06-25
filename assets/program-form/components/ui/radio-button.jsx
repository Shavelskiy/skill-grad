import React from 'react'

import css from './radion-button.scss?module'
import cn from 'classnames'


const RadioButton = ({children, selected = false, checked = false, click}) => {

  return (
    <div className={css.radio} onClick={click}>
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
