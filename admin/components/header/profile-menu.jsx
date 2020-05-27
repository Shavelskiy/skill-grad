import React, { useState, useEffect, useRef } from 'react';
import css from './profile-menu.scss';

const ProfileMenu = () => {
  const [hideMenu, setHideMenu] = useState(true);

  const ref = useRef();

  useEffect(() => {
      const listener = event => {
        if (!ref.current || ref.current.contains(event.target)) {
          return;
        }

        setHideMenu(true)
      };

      document.addEventListener('mousedown', listener);
      document.addEventListener('touchstart', listener);

      return () => {
        document.removeEventListener('mousedown', listener);
        document.removeEventListener('touchstart', listener);
      };
    },
    [ref, setHideMenu]
  );

  return (
    <div className="profile-container" ref={ref}>
      <div className="user-profile" onClick={() => setHideMenu(!hideMenu)}>
        <span>Admin admin</span>
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
            <a href="/">Выход</a>
          </li>
        </ul>
      </div>
    </div>
  );
};

export default ProfileMenu;
