import React from 'react';
import css from './header.scss';
import ProfileMenu from './profile-menu';

class Header extends React.Component {
  render() {
    return (
      <div className="header">
        <ProfileMenu/>
      </div>
    );
  }
}

export default Header;
