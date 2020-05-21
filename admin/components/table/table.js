import React from 'react';
import css from './table.scss';
import ActionItem from './action-item';
import {Link} from 'react-router-dom';

class Table extends React.Component {
  hasActions() {
    return this.props.actions && this.props.actions.length >= 0;
  }

  renderActions(item) {
    if (!this.hasActions()) {
      return null;
    }

    const actions = this.props.actions.map((action, key) => {
      return (
        <ActionItem
          key={key}
          action={action}
          item={item}
        />
      )
    });

    return (
      <td>
        <div className="actions">
          {actions}
        </div>
      </td>
    );
  }

  render() {
    const header = this.props.table.map((item, key) => {
      return (
        <th
          key={key}
          onClick={() => {
            this.props.changeOrder(item.name)
          }}
        >
          <div>
            <span>{item.title}</span>
            <i className={
              (this.props.order[item.name] === 'asc') ? 'fa fa-arrow-up' :
                ((this.props.order[item.name] === 'desc') ? 'fa fa-arrow-down' : 'fa fa-arrow-up hidden')
            }
            ></i>
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
          <td className="numbering">{key + 1}</td>
          {row}
          {this.renderActions(bodyItem)}
        </tr>
      );
    });

    return (
      <table className={ `table ${this.props.disabled ? 'disabled' : ''}` }>
        <thead>
        <tr>
          <th></th>
          { header }
          { this.hasActions() ? (<th></th>) : null }
        </tr>
        </thead>
        <tbody>
        {body}
        </tbody>
      </table>
    );
  }
}

export default Table;
