import React from 'react';

export function Item(props) {
  return (
    <li
      className={`item ${props.active ? 'active' : ''}`}
      onClick={() => props.click(props.page)}
    >
      <div className="link">{props.page}</div>
    </li>
  );
}

export function EmptyItem(props) {
  return (
    <li className="item">
      <div className="link">...</div>
    </li>
  );
}

export function Arrow(props) {
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
}
