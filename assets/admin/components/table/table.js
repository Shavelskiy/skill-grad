import React from 'react';
import css from './table.scss';

class Table extends React.Component {
  render() {
    const header = this.props.header.map((headerItem, key) => {
      return (
        <th key={key}>
          {headerItem}
        </th>
      );
    });

    const body = this.props.body.map((bodyItem, key) => {
      const row = this.props.bodyKeys.map((bodyKey, key) => {
        return (
          <td key={key}>
            {bodyItem[bodyKey]}
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
      <table className="table table-bordered table-hover">
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
