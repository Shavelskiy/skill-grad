import React, { useState, useEffect, useRef } from 'react'
import { Link, useHistory, useLocation } from 'react-router-dom'
import { INDEX, LOGIN } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setCurrentUser, setRedirectLink } from '../../redux/actions'

import axios from 'axios'
import { LOGOUT_URL } from '../../utils/api/endpoints'

import css from './profile-menu.scss?module'
import cn from 'classnames'


const ProfileMenu = () => {
  const dispatch = useDispatch()
  const history = useHistory()
  const location = useLocation()
  const ref = useRef()

  const currentUser = useSelector(state => state.currentUser)
  const [hideMenu, setHideMenu] = useState(true)

  useEffect(() => {
    const listener = event => {
      if (!ref.current || ref.current.contains(event.target)) {
        return
      }

      setHideMenu(true)
    }

    document.addEventListener('mousedown', listener)
    document.addEventListener('touchstart', listener)

    return () => {
      document.removeEventListener('mousedown', listener)
      document.removeEventListener('touchstart', listener)
    }
  }, [ref, setHideMenu])

  const logout = () => {
    axios.get(LOGOUT_URL)
      .then(({data}) => {
        dispatch(setCurrentUser(null))
        dispatch(setRedirectLink(location))
        history.push(LOGIN)
      })
  }

  if (currentUser === null) {
    return <></>;
  }

  return (
    <div className={css.container} ref={ref}>
      <div className={css.userProfile} onClick={() => setHideMenu(!hideMenu)}>
        <span>{currentUser.username}</span>
      </div>

      <div className={cn(css.card, {[css.hidden]: hideMenu})}>
        <ul>
          <li className={css.list}>
            <Link to={INDEX}>
              <i className="fas fa-user"></i>
              <span>Редактировать профиль</span>
            </Link>
          </li>
          <li className={css.line}></li>
          <li className={css.logout}>
            <button
              onClick={() => logout()}
            >
              Выход
            </button>
          </li>
        </ul>
      </div>
    </div>
  )
}

export default ProfileMenu
