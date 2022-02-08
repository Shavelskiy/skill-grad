import React from 'react'

import Button from '../ui/button'

import css from './panel-title.scss?module'


const PanelTitle = ({icon, title, withButton, buttonLink, buttonText}) => {
  let buttonTemplate = ''
  if (withButton === true) {
    buttonTemplate = (
      <div className={css.buttonWrap}>
        <Button
          link={buttonLink}
          create={true}
          text={buttonText}
        />
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
