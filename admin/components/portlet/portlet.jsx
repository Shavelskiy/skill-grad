import React from 'react'

import PanelTitle from './panel-title'

import css from './portlet.scss?module'
import cn from 'classnames'


const Portlet = ({children, width, title, titleIcon, withButton, buttonLink}) => {
  let widthClass = ''

  switch (width) {
    case 50:
      widthClass = css.w50
      break
  }

  return (
    <div className={cn(css.portlet, widthClass)}>
      <PanelTitle
        title={title}
        icon={`fa fa-${titleIcon}`}
        withButton={withButton}
        buttonLink={buttonLink}
      />
      <div className={css.body}>
        {children}
      </div>
    </div>
  )
}

export default Portlet
