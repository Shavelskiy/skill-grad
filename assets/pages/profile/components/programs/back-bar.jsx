import React from 'react'

import {useSelector} from 'react-redux'

import {Link} from 'react-router-dom'
import {PROGRAMS} from '@/utils/profile/routes'

import css from './back-bar.scss?module'


const BackBar = ({title}) => {
  return (
    <h3 className={css.resultTitle}>
      <Link to={PROGRAMS} className={css.back}>
        <i className="icon-left"></i>
        <span className="back-text">Вернуться<br/>к программам</span>
      </Link>
      {title}&nbsp;<br className="show-mobile"/>«{useSelector(state => state.programTitle)}»
    </h3>
  )
}

export default BackBar
