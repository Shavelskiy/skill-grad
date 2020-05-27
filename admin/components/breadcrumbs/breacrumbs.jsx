import React from 'react';
import css from './breadcrumbs.scss';
import BreadcrumbItem from './item';

const Breadcrumbs = ({items}) => {
  return (
    <div className="breadcrumb-wrap">
      <ol className="breadcrumb">
        {
          items.map((item, key) => {
            return (<BreadcrumbItem key={key} item={item}/>);
          })
        }
      </ol>
    </div>
  );
};

export default Breadcrumbs;
