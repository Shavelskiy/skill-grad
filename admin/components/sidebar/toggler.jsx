import React from 'react';
import css from './toggler.scss';

const Toggler = ({active, click}) => {
  return (
    <button
      className={`toggler ${active ? 'active' : ''}`}
      onClick={() => click()}
    >
      <span></span>
    </button>
  );
};

export default Toggler;
