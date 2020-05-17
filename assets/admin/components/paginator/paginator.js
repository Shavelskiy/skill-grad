import React from 'react';
import css from './paginator.scss';

class Paginator extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-12 col-7">
          <ul className="pagination">

            <li className="page-item active">
              <div className="page-link">1</div>
            </li>
            <li className="page-item">
              <a className="page-link" href="/admin/location/?page=2">2</a>
            </li>

            <li className="page-item">
              <a className="page-link" href="/admin/location/?page=2">»</a>
            </li>
          </ul>
        </div>
      </div>
    );
  }
}

export default Paginator;
