import React from 'react'

import css from './scss/button.scss?module'
import cn from 'classnames'


const Button = ({text = '', red = false, blue = false, click}) => {
  return (
    <div
      onClick={click}
      className={cn(
        css.button,
        {[css.red]: red},
        {[css.blue]: blue},
      )}
    >
      <span>{text}</span>
    </div>
  )
}

export default Button
