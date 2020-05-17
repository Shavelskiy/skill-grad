import React from 'react';
import css from './breadcrumbs.scss';

class Breadcrumbs extends React.Component {
  render() {
    return (
      <ol className="breadcrumb">
        <li className="breadcrumb-item">
          <a href="/admin/">Главная</a>
        </li>
        <li className="breadcrumb-item active">
          Список местоположений
        </li>
      </ol>
    );
  }
}

export default Breadcrumbs;
