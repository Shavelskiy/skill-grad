import React from 'react'

import css from './preloader.scss?module'
import cn from 'classnames'


const Preloader = ({active}) => {
  return (
    <div className={cn(css.preloader, {[css.active]: active})}>
      <div className={css.spinner}>
        <div></div>
      </div>
    </div>
  )
}

export default Preloader
