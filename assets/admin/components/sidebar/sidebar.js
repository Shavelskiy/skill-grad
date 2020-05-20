import React from 'react';
import css from './sidebar.scss';
import logo from "../../images/logo.png";
import Toggler from './toggler';
import MenuItem from "./menuItem";

class Sidebar extends React.Component {
  render() {
    const menuItems = [
      {
        title: 'Блог',
        icon: 'fa fa-rss-square',
        items: [
          {
            title: 'Статьи',
            link: '/articles',
          },
          {
            title: 'Теги',
            link: '/tags',
          },
          {
            title: 'Рубрики',
            link: '/rubrics',
          },
        ],
      },
      {
        title: 'Настройки пользователей',
        icon: 'fa fa-users',
        items: [
          {
            title: 'Все пользователи',
            link: '/users',
          },
        ],
      },
      {
        title: 'Настройки местоположений',
        icon: 'fa fa-globe',
        items: [
          {
            title: 'Список всех местоположений',
            link: '/locations',
          },
        ],
      },
    ];

    const menu = menuItems.map((rootItem, key) => {
      return (
        <MenuItem rootItem={rootItem} key={key} />
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
            <Toggler />
          </div>
        </div>

        <div className="menu-container">
          <ul>{menu}</ul>
        </div>
      </div>
    );
  }
}

export default Sidebar;

// let sidebarToggler = document.querySelector('.sidebar-toggler');
// sidebarToggler.addEventListener('click', function () {
//   this.classList.toggle('sidebar-toggler--active');
//   let content = document.getElementsByClassName('main')[0];
//   content.classList.toggle('main--active');
// });
