import React from 'react'
import { Link } from 'react-router-dom'
import css from './panel-title.scss'

const PanelTitle = ({icon, title, withButton, buttonLink, buttonText}) => {
  let buttonTemplate = ''
  if (withButton === true) {
    buttonTemplate = (
      <div className="button-wrap">
        <Link
          to={buttonLink}
          className="btn primary"
        >
          Создать
        </Link>
      </div>
    )
  }

  return (
    <div className="panel-title">
      <h3>
        <i className={icon}></i>
        {title}
      </h3>
      {buttonTemplate}
    </div>
  )
}

export default PanelTitle
