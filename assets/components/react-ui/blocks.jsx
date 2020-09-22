import React from 'react'

import css from './scss/blocks.scss?module'
import cn from 'classnames'


export const ScrollBlock = ({children, container}) => {
  return (
    <div className={cn(css.scrollBlock, container)}>
      {children}
    </div>
  )
}
