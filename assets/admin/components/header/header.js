import React from 'react';
import css from './header.scss';

class Header extends React.Component {
  render() {
    return (
      <div className="main-header">
        <div className="container-fluid">
          <div className="row h-100">
            <div className="col-2 offset-10 h-100 profile-container">
              <div className="user-profile">
                <span>Kekekek ekekke</span>
              </div>

              <div className="user-profile-card user-profile-card-hidden">
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
          </div>
        </div>
      </div>
    );
  }
}

export default Header;