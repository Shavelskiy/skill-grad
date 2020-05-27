import React from 'react';
import { Link } from 'react-router-dom';

const BreadcrumbItem = ({item}) => {
  const renderContent = () => {
    if (item.link === null) {
      return <span>{item.title}</span>
    } else {
      return <Link to={item.link}>{item.title}</Link>
    }
  };

  return (
    <li className={`item ${(item.link === null) ? 'active' : ''}`}>
      {renderContent()}
    </li>
  );
}

export default BreadcrumbItem;