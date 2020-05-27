import React from 'react'
import css from './table.scss'
import ActionItem from './action-item'
import { Link } from 'react-router-dom'

const Table = ({table, body, order, hasActions, actions, disabled, changeOrder}) => {
  const isHasActions = () => {
    return actions && actions !== undefined && actions.length >= 0
  }

  const renderActions = (item) => {
    if (!isHasActions()) {
      return null
    }

    return (
      <td className="actions">
        <div className="wrap">
          {
            actions.map((action, key) => {
              return (
                <ActionItem
                  key={key}
                  action={action}
                  item={item}
                />
              )
            })
          }
        </div>
      </td>
    )
  }

  return (
    <table className={`table ${disabled ? 'disabled' : ''}`}>
      <thead>
      <tr>
        <th></th>
        {
          table.map((item, key) => {
            return (
              <th
                key={key}
                onClick={() => changeOrder(item.name)}
              >
                <div>
                  <span>{item.title}</span>
                  <i className={
                    (order[item.name] === 'asc') ? 'fa fa-arrow-up' :
                      ((order[item.name] === 'desc') ? 'fa fa-arrow-down' : 'fa fa-arrow-up hidden')
                  }
                  ></i>
                </div>
              </th>
            )
          })
        }
        {isHasActions() ? (<th></th>) : null}
      </tr>
      </thead>
      <tbody>
      {
        body.map((bodyItem, key) => {
          const row = table.map((item, key) => {
            return (
              <td key={key}>
                {bodyItem[item.name]}
              </td>
            )
          })

          return (
            <tr key={key}>
              <td className="numbering">{key + 1}</td>
              {row}
              {renderActions(bodyItem)}
            </tr>
          )
        })
      }
      </tbody>
    </table>
  )
}

export default Table
