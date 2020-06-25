import React from 'react'

import css from './block.scss?module'
import addButtonImage from './../../img/plus.svg'

const Block = ({children, title, link = null, linkClick}) => {
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
    <div className={css.block}>
      <div className={css.title}>
        <h2>{title}</h2>
        {renderLink()}
      </div>
      {children}
    </div>
  )
}

export default Block
