import React from 'react'
import { useSelector } from 'react-redux'

import css from './preloader.scss?module'
import cx from 'classnames'


const Preloader = ({active}) => {
  return (
    <div className={cx(css.preloader, {[css.active]: active})}>
      <div className={css.spinner}>
        <div></div>
      </div>
    </div>
  )
}

export default Preloader
