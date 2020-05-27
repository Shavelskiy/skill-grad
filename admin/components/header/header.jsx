import React from 'react';
import css from './header.scss';
import ProfileMenu from './profile-menu';

const Header = () => {
  return (
    <div className="header">
      <ProfileMenu/>
    </div>
  );
};

export default Header;