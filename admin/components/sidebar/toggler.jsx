import React from 'react'

import css from './toggler.scss?module'
import cn from 'classnames'


const Toggler = ({active, click}) => {
  return (
    <button
      className={cn(css.toggler, {[css.active]: active})}
      onClick={() => click()}
    >
      <span></span>
    </button>
  )
}

export default Toggler
