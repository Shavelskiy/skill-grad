import React from 'react';
import { Link } from 'react-router-dom';

const ActionItem = ({action, item}) => {
  const renderViewAction = () => {
    return (
      <Link to={`${action.link}/${item.id}`}>
        <i className="fa fa-eye"></i>
      </Link>
    )
  }

  switch (action.type) {
    case 'view':
      return renderViewAction();
    default:
      return (null);
  }
}

export default ActionItem;
