import React, { useState, useEffect, useRef } from 'react'
import { useHistory, useLocation } from 'react-router-dom'
import { LOGIN } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setCurrentUser, setRedirectLink } from '../../redux/actions'

import axios from 'axios'
import { LOGOUT_URL } from '../../utils/api/endpoints'

import css from './profile-menu.scss'


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
    <div className="profile-container" ref={ref}>
      <div className="user-profile" onClick={() => setHideMenu(!hideMenu)}>
        <span>{currentUser.username}</span>
      </div>

      <div className={`user-profile-card ${hideMenu ? 'hidden' : ''}`}>
        <ul>
          <li className="list">
            <a href="/admin">
              <i className="fas fa-user"></i>
              <span>Редактировать профиль</span>
            </a>
          </li>
          <li className="line"></li>
          <li className="logout">
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
