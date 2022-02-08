import React from 'react'

import { useDispatch } from 'react-redux'

import css from './scss/block.scss?module'
import addButtonImage from './../../../img/svg/plus.svg'


const Block = ({children, title, link = null, linkClick, containerClass, onFocus}) => {
  const dispatch = useDispatch()

  const renderLink = () => {
    if (link === null) {
      return <></>
    }

    return (
      <div onClick={linkClick} className={css.link}>
        <span>{link}</span>
        <img src={addButtonImage}/>
      </div>
    )
  }

  return (
    <>
      <div className={css.title}>
        <h2>{title}</h2>
        {renderLink()}
      </div>
      <div className={containerClass} onClick={() => dispatch(onFocus())}>
        {children}
      </div>
    </>
  )
}

export default Block
