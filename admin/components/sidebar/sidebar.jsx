import React from 'react';
import css from './sidebar.scss';
import logo from '../../images/logo.png';
import Toggler from './toggler';
import MenuItem from './menu-item';

const Sidebar = ({opened, toggle}) => {
  const menuItems = [
    {
      title: 'Блог',
      icon: 'fa fa-rss-square',
      items: [
        {
          title: 'Статьи',
          link: '/article',
        },
        {
          title: 'Теги',
          link: '/tag',
        },
        {
          title: 'Рубрики',
          link: '/rubric',
        },
      ],
    },
    {
      title: 'Настройки пользователей',
      icon: 'fa fa-users',
      items: [
        {
          title: 'Все пользователи',
          link: '/user',
        },
      ],
    },
    {
      title: 'Настройки местоположений',
      icon: 'fa fa-globe',
      items: [
        {
          title: 'Список всех местоположений',
          link: '/location',
        },
      ],
    },
  ];

  const menu = menuItems.map((rootItem, key) => {
    return (
      <MenuItem rootItem={rootItem} key={key}/>
    );
  })

  return (
    <div className="sidebar-container">
      <div className="sidebar-header">
        <div className="sidebar-header__logo">
          <a href="/">
            <img alt="Logo" src={logo}/>
          </a>
        </div>
        <div className="sidebar-tools-wrapper">
          <Toggler
            active={!opened}
            click={() => toggle()}
          />
        </div>
      </div>

      <div className="menu-container">
        <ul>{menu}</ul>
      </div>
    </div>
  );
};

export default Sidebar;
