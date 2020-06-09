import React from 'react'
import { Link } from 'react-router-dom'

import css from './button.scss?module'
import cn from 'classnames'


const Button = ({link = null, text, click, disabled = false, create = false, primary = false, success = false, danger = false}) => {
  const className = cn(
    css.btn,
    {[css.create]: create},
    {[css.primary]: primary},
    {[css.success]: success},
    {[css.danger]: danger},
  )

  if (link !== null) {
    return (
      <Link
        to={link}
        className={className}
      >
        {text}
      </Link>
    )
  }

  return (
    <button
      className={className}
      disabled={disabled}
      onClick={() => click()}
    >
      {text}
    </button>
  )
}

export default Button
