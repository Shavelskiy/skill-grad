import React from 'react'
import { Link } from 'react-router-dom'

import axios from 'axios'
import css from './actions.scss?module'
import { ACTION_DELETE, ACTION_UPDATE, ACTION_VIEW } from '../../utils/table-actions'


const ViewAction = ({action, item}) => {
  return (
    <Link to={action.link.replace(':id', item.id)} className={css.item}>
      <i className="fa fa-eye"></i>
    </Link>
  )
}

const UpdateAction = ({action, item}) => {
  return (
    <Link to={action.link.replace(':id', item.id)} className={css.item}>
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
    <div className={css.item} onClick={() => deleteItem()}>
      <i className="fa fa-trash"></i>
    </div>
  )
}

const TableActions = ({actions, item, reload}) => {
  if (actions.length < 1) {
    return <></>
  }

  const tableActions = actions.map((action, key) => {
    switch (action.type) {
      case ACTION_VIEW:
        return <ViewAction key={key} action={action} item={item}/>
      case ACTION_UPDATE:
        return <UpdateAction key={key} action={action} item={item}/>
      case ACTION_DELETE:
        return <DeleteAction key={key} action={action} item={item} reload={reload}/>
      default:
        return <></>
    }
  })


  return (
    <td className={css.actions}>
      <div className={css.wrap}>
        {tableActions}
      </div>
    </td>
  )
}

export default TableActions
