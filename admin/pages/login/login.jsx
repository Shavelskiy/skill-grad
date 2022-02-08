import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { INDEX, LOGIN } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setCurrentUser, setTitle } from '../../redux/actions'

import axios from 'axios'
import { LOGIN_URL } from '../../utils/api/endpoints'

import css from './login.scss?module'
import cn from 'classnames'


const Login = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  const currentUser = useSelector(state => state.currentUser)
  const redirectLink = useSelector(state => state.redirectLink)

  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState(null)
  const [lock, setLock] = useState(false)

  useEffect(() => {
    if (currentUser !== null) {
      history.push(INDEX)
    }

    dispatch(setTitle('Авторизация'))
  }, [])

  const loginAction = () => {
    setLock(true)
    setError(null)
    axios.post(LOGIN_URL, {
      email: email,
      password: password
    })
      .then(({data}) => {
        dispatch(setCurrentUser(data.current_user))

        if (redirectLink === null || redirectLink.pathname === LOGIN) {
          history.push(INDEX)
        } else {
          history.push(redirectLink)
        }
      })
      .catch(({response}) => {
        setError(response.data.message)
        setLock(false)
      })
  }

  return (
    <div className={css.page}>
      <div className={cn(css.container, {[css.lock]: lock})}>
        <h3>Авторизация</h3>
        <div className={css.form}>
          <div className={cn(css.error, {[css.active]: error !== null})}>
            <span>{error}</span>
          </div>
          <div className={css.group}>
            <input
              type="text"
              placeholder="Логин"
              name="text"
              value={email}
              onChange={(event) => setEmail(event.target.value)}
            />
          </div>
          <div className={css.group}>
            <input
              type="password"
              placeholder="Пароль"
              name="password"
              value={password}
              onChange={(event) => setPassword(event.target.value)}
            />
          </div>

          <div className={css.actions}>
            <button
              onClick={() => loginAction()}
              disabled={lock}
            >
              Войти
            </button>
          </div>
        </div>
      </div>
    </div>
  )
}

export default Login
