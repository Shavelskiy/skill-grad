import React, { useEffect, useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { showAlert } from '../../redux/actions'

import css from './alert.scss?module'
import cn from 'classnames'


const Alert = () => {
  const [active, setActive] = useState(false)
  const dispatch = useDispatch()
  const message = useSelector(state => state.alertMessage)

  useEffect(() => {
    if (message !== null) {
      setActive(true)
      setTimeout(() => {
        setActive(false)
      }, 2000)
    }
  }, [message])

  useEffect(() => {
    if (active === false) {
      setTimeout(() => dispatch(showAlert(null)), 500)
    }
  }, [active])

  return (
    <div className={cn(css.alert, {[css.active]: active})}>
      <span>{message}</span>
    </div>
  )
}

export default Alert
