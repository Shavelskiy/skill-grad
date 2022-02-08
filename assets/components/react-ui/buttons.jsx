import React from 'react'

import css from './scss/buttons.scss?module'
import cn from 'classnames'


export const Button = ({text, click, disabled = false, red = false, blue = false, fullWidth = true}) => {
  return (
    <button
      className={cn(
        css.button,
        {[css.fullWidth]: fullWidth},
        {[css.blue]: blue},
        {[css.red]: red},
      )}
      disabled={disabled}
      onClick={click}
    >
      {text}
    </button>
  )
}

export const SmallButton = ({text, click, disabled = false, red = false, blue = false, grey = false}) => {
  return (
    <button
      className={cn(
        css.smallButton,
        {[css.smallBlue]: blue},
        {[css.smallRed]: red},
        {[css.smallGrey]: grey},
      )}
      onClick={click}
      disabled={disabled}
    >
      {text}
    </button>
  )
}
