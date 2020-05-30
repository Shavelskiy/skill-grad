import React from 'react'
import { Link } from 'react-router-dom'

import css from './panel-title.scss?module'


const PanelTitle = ({icon, title, withButton, buttonLink, buttonText}) => {
  let buttonTemplate = ''
  if (withButton === true) {
    buttonTemplate = (
      <div className={css.buttonWrap}>
        <Link
          to={buttonLink}
          className="btn create"
        >
          Создать
        </Link>
      </div>
    )
  }

  return (
    <div className={css.panelTitle}>
      <h3>
        <i className={icon}></i>
        {title}
      </h3>
      {buttonTemplate}
    </div>
  )
}

export default PanelTitle
