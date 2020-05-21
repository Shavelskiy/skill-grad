import React from 'react';
import css from './toggler.scss';

class Toggler extends React.Component {
  render() {
    return (
      <button
        className={`toggler ${this.props.active ? 'active' : ''}`}
        onClick={() => this.props.click()}
      >
        <span></span>
      </button>
    );
  }
}

export default Toggler;
