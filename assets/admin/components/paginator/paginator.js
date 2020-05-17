import React from 'react';
import css from './paginator.scss';

class Paginator extends React.Component {
  render() {
    return (
      <ul className="pagination">
        <li className="item active">
          <div className="link">1</div>
        </li>
        <li className="item">
          <a className="link" href="/admin/location/?page=2">2</a>
        </li>

        <li className="item">
          <a className="link" href="/admin/location/?page=2">»</a>
        </li>
      </ul>
    );
  }
}

export default Paginator;
