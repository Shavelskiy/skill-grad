import React from 'react';
import css from './profile-menu.scss';

class ProfileMenu extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      hideMenu: true,
    };

    this.setWrapperRef = this.setWrapperRef.bind(this);
    this.handleClickOutside = this.handleClickOutside.bind(this);
  }

  toggleMenu() {
    const hideMenu = this.state.hideMenu;
    this.setState({
      hideMenu: !hideMenu,
    });
  };

  componentDidMount() {
    document.addEventListener('mousedown', this.handleClickOutside);
  }

  componentWillUnmount() {
    document.removeEventListener('mousedown', this.handleClickOutside);
  }

  setWrapperRef(node) {
    this.wrapperRef = node;
  }

  handleClickOutside(event) {
    if (this.wrapperRef && !this.wrapperRef.contains(event.target)) {
      this.setState({
        hideMenu: true,
      });
    }
  }

  render() {
    return (
      <div className="profile-container" ref={this.setWrapperRef}>
        <div className="user-profile" onClick={() => this.toggleMenu()}>
          <span>Admin admin</span>
        </div>

        <div className={`user-profile-card ${this.state.hideMenu ? 'hidden' : ''}`}>
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
  }
}

export default ProfileMenu;
