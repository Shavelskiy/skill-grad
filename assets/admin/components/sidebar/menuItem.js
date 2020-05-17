import React from 'react';
import css from './menuItem.scss';

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
          <div className="item">
            <i className="point"><span></span></i>
            <a className="text" href={childItems.link}>{childItems.title}</a>
          </div>
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
