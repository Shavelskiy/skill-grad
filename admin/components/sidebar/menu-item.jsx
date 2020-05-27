import React, { useState } from 'react';
import css from './menu-item.scss';
import { Link } from 'react-router-dom';

const MenuItem = ({rootItem}) => {
  const [collapse, setCollapse] = useState(false);

  const items = rootItem.items.map((childItems, key) => {
    return (
      <li key={key}>
        <Link className="item" to={childItems.link}>
          <i className="point"><span></span></i>
          <span className="text">{childItems.title}</span>
        </Link>
      </li>
    );
  });

  return (
    <li onClick={() => setCollapse(!collapse)} className="menu-item">
      <div className={`item ${collapse ? 'active' : ''}`}>
        <i className={rootItem.icon}></i>
        <div className="text">&nbsp;{rootItem.title}</div>
        <i className="menu-arrow menu-arrow-right"></i>
      </div>
      <ul className={`collapse-content ${collapse ? 'active' : ''}`}>
        {items}
      </ul>
    </li>
  );
};

export default MenuItem;
