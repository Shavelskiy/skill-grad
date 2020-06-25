import React, { useEffect, useRef } from 'react'

import css from './modal.scss?module'
import cn from 'classnames'

import closeImg from './../../img/close.svg'


const Modal = ({children, title = null, active, close}) => {
  const ref = useRef()

  useEffect(() => {
    const listener = event => {
      if (!ref.current || ref.current.contains(event.target)) {
        return
      }

      close()
    }

    document.addEventListener('mousedown', listener)

    return () => {
      document.removeEventListener('mousedown', listener)
    }
  }, [ref])

  const renderTitle = () => {
    if (title === null) {
      return <></>
    }

    return (
      <div className={css.title}>
        <h6>{title}</h6>
      </div>
    )
  }

  return (
    <div className={cn(css.modalContainer, {[css.active]: active})}>
      <div className={css.modal} ref={ref}>
        <div className={css.body}>
          <div
            className={css.close}
            onClick={close}
          >
            <img src={closeImg}/>
          </div>
          {renderTitle()}
          {children}
        </div>
      </div>
    </div>
  )
}

export default Modal
