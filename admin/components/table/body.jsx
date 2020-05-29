import React from 'react'
import ActionItem from './action-item'

const TableBody = ({body, table, actions, reload}) => {
  const renderActions = (item) => {
    if (actions.length < 1) {
      return <></>
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
                  reload={reload}
                />
              )
            })
          }
        </div>
      </td>
    )
  }

  return (
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
  )
}

export default TableBody
