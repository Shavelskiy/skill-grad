import React, { useEffect, useRef } from 'react'

import cn from 'classnames'
import css from './modal.scss?module'


const Modal = ({children, wide = false, active, title = '', close, error = ''}) => {
  const ref = useRef()

  useEffect(() => {
    const listener = event => {
      if (ref.current && ref.current === event.target) {
        close()
      }
    }

    document.addEventListener('mousedown', listener)

    return () => {
      document.removeEventListener('mousedown', listener)
    }
  }, [ref, close])

  return (
    <div ref={ref} className={cn(css.modal, {[css.active]: active})}>
      <div className={cn(css.modalContent, {[css.wide]: wide})}>
        <span className={css.close} onClick={close}>&times;</span>
        <div className={css.content}>
          <h4>{title}</h4>
          <span className={css.error}>{error}</span>
          {children}
        </div>
      </div>
    </div>
  )
}

export default Modal
