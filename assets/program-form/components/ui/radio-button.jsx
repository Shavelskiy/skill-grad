import React from 'react'

import css from './radion-button.scss?module'
import cn from 'classnames'


const RadioButton = ({children, selected = false, click}) => {

  return (
    <div className={css.radio}>
      <span
        onClick={click}
        className={cn(css.point, {[css.selected]: selected})}
      >
      </span>
      <span className={css.value}>{children}</span>
    </div>
  )
}

export default RadioButton
