import React from 'react';
import css from './preloader.scss';
import loader from '../../images/loader.gif';

const Preloader = () => {
  return (
    <div className="preloader hide">
      <img src={loader}/>
    </div>
  );
};

export default Preloader;