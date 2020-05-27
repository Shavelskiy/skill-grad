import React from 'react';

export const Item = (props) => {
  return (
    <li
      className={`item ${props.active ? 'active' : ''}`}
      onClick={() => props.click(props.page)}
    >
      <div className="link">{props.page}</div>
    </li>
  );
};

export const EmptyItem = (props) => {
  return (
    <li className="item">
      <div className="link">...</div>
    </li>
  );
};

export const Arrow = (props) => {
  let content = '';
  if (props.left) {
    content = (<div className="link">&laquo;</div>);
  } else {
    content = (<div className="link">&raquo;</div>);
  }

  return (
    <li
      className="item"
      onClick={() => props.click(props.page)}
    >
      {content}
    </li>
  );
};
