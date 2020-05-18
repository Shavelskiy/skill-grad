import React from 'react';
import css from './paginator.scss';

class Paginator extends React.Component {
  render() {
    let items = [];

    for (let i = 1; i <= this.props.totalPages; i++) {
      items.push(
        <li
          key={i}
          className={`item ${(i === this.props.currentPage) ? 'active' : ''}`}
          onClick={() => this.props.click(i)}
        >
          <div className="link">{i}</div>
        </li>
      );
    }

    return (
      <ul className="pagination">
        {items}
      </ul>
    );
  }
}

export default Paginator;
