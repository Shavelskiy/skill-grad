import React from 'react';
import css from './table.scss';

class Table extends React.Component {
  render() {
    const header = this.props.table.map((item, key) => {
      let orderClass = 'fa fa-arrow-up hidden';

      if (this.props.order[item.name] === 'asc') {
        orderClass = 'fa fa-arrow-up';
      } else if (this.props.order[item.name] === 'desc') {
        orderClass = 'fa fa-arrow-down';
      }

      return (
        <th
          key={key}
          onClick={() => {
            this.props.changeOrder(item.name)
          }}
        >
          <div>
            <span>{item.title}</span>
            <i className={orderClass}></i>
          </div>
        </th>
      );
    });

    const body = this.props.body.map((bodyItem, key) => {
      const row = this.props.table.map((item, key) => {
        return (
          <td key={key}>
            {bodyItem[item.name]}
          </td>
        );
      });

      return (
        <tr key={key}>
          {row}
        </tr>
      );
    });

    return (
      <table className={`table ${this.props.disabled ? 'disabled' : ''}`}>
        <thead>
        <tr>{header}</tr>
        </thead>
        <tbody>
        {body}
        </tbody>
      </table>
    );
  }
}

export default Table;
