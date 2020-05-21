import React from 'react';
import css from './menu-item.scss';
import {Link} from 'react-router-dom';

class MenuItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      collapse: false,
    };
  }

  onClick() {
    let collapse = this.state.collapse;
    this.setState({
      collapse: !collapse,
    })
  }

  render() {
    const items = this.props.rootItem.items.map((childItems, key) => {
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
      <li onClick={() => this.onClick()} className="menu-item">
        <div className={`item ${this.state.collapse ? 'active' : ''}`}>
          <i className={this.props.rootItem.icon}></i>
          <div className="text">&nbsp;{this.props.rootItem.title}</div>
          <i className="menu-arrow menu-arrow-right"></i>
        </div>
        <ul className={`collapse-content ${this.state.collapse ? 'active' : ''}`}>
          {items}
        </ul>
      </li>
    );
  }
}

export default MenuItem;
