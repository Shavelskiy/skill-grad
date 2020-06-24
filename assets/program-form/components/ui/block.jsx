import React from 'react'

import css from './block.scss?module'


const Block = ({children, title}) => {
  return (
    <div className={css.block}>
      <h2>{title}</h2>
      {children}
    </div>
  )
}

export default Block
