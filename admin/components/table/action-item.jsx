import React from 'react'
import axios from 'axios'
import { Link } from 'react-router-dom'

const ViewAction = ({action, item}) => {
  return (
    <Link to={`${action.link}/${item.id}`} className="item">
      <i className="fa fa-eye"></i>
    </Link>
  )
}

const UpdateAction = ({action, item}) => {
  return (
    <Link to={`${action.link}/update/${item.id}`} className="item">
      <i className="fa fa-edit"></i>
    </Link>
  )
}

const DeleteAction = ({action, item, reload}) => {
  const deleteItem = () => {
    if (!confirm('Вы уверены что хотите удалить элемент?')) {
      return
    }

    const params = {
      id: item.id
    }

    axios.delete(action.link, {params: params})
      .then(() => reload())
  }

  return (
    <div className="item" onClick={() => deleteItem()}>
      <i className="fa fa-trash"></i>
    </div>
  )
}

const ActionItem = ({action, item, reload}) => {
  switch (action.type) {
    case 'view':
      return (<ViewAction action={action} item={item}/>)
    case 'update':
      return (<UpdateAction action={action} item={item}/>)
    case 'delete':
      return (<DeleteAction action={action} item={item} reload={reload}/>)
    default:
      return (null)
  }
}

export default ActionItem
