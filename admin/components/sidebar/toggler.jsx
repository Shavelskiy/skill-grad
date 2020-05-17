import React from 'react'

import css from './toggler.scss?module'
import cx from 'classnames'


const Toggler = ({active, click}) => {
  return (
    <button
      className={cx(css.toggler, {[css.active]: active})}
      onClick={() => click()}
    >
      <span></span>
    </button>
  )
}

export default Toggler
