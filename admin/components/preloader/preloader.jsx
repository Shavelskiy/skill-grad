import React from 'react'
import { useSelector } from 'react-redux'
import css from './preloader.scss'

const Preloader = ({active}) => {
  return (
    <div className={`preloader ${active ? 'active' : ''}`}>
      <div className="spinner">
        <div></div>
      </div>
    </div>
  )
}

export default Preloader
