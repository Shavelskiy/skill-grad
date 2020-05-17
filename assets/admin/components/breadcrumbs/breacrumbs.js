import React from 'react';
import css from './breadcrumbs.scss';

class Breadcrumbs extends React.Component {
  render() {
    return (
      <div className="breadcrumb-wrap">
        <ol className="breadcrumb">
          <li className="item">
            <a href="/admin/">Главная</a>
          </li>
          <li className="item active">
            Список местоположений
          </li>
        </ol>
      </div>
    );
  }
}

export default Breadcrumbs;
