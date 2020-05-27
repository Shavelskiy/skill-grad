import React from 'react'
import { Link } from 'react-router-dom'

const ActionItem = ({action, item}) => {
  const renderViewAction = () => {
    return (
      <Link to={`${action.link}/${item.id}`}>
        <i className="fa fa-eye"></i>
      </Link>
    )
  }

  const renderUpdateAction = () => {
    return (
      <Link to={`${action.link}/update/${item.id}`}>
        <i className="fa fa-edit"></i>
      </Link>
    )
  }

  switch (action.type) {
    case 'view':
      return renderViewAction()
    case 'update':
      return renderUpdateAction()
    default:
      return (null)
  }
}

export default ActionItem
