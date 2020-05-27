import React from 'react';
import { useSelector } from 'react-redux';
import css from './preloader.scss';

const Preloader = () => {
  const loading = useSelector(state => state.loading);

  return (
    <div className={`preloader ${loading ? 'active' : ''}`}>
      <div className="spinner">
        <div></div>
      </div>
    </div>
  );
};

export default Preloader;