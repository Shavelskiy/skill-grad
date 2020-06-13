import React from 'react'

import TableActions from './actions'
import { BOOLEAN, IMAGE } from '../../utils/table-item-display'

import css from './table.scss?module'
import cn from 'classnames'

const BoolColumn = ({isTrue, width}) => {
  return (
    <div className={cn(css.col, css.boolean)} style={{flex: width}}>
      <div className={css.content}>
        <span className={cn(
          {[css.true]: isTrue},
          {[css.false]: !isTrue}
        )}>
          {isTrue ? 'Да' : 'Нет'}
        </span>
      </div>
    </div>
  )
}

const ImageColumn = ({value, width}) => {
  return (
    <div className={cn(css.col, css.img)} style={{flex: width}}>
      <div className={css.content}>
        <img src={value}/>
      </div>
    </div>
  )
}

const DefaultColumn = ({value, width}) => {
  return (
    <div className={css.col} style={{flex: width}}>
      <div className={css.content}>{value}</div>
    </div>
  )
}

const TableBody = ({body, table, actions, reload}) => {
  let totalWidth = 0
  table.forEach(item => {
    totalWidth += item.width
  })

  return (
    <div>
      {
        body.map((bodyItem, key) => {
          const row = table.map((item, rowKey) => {
            const value = bodyItem[item.name]
            const width = item.width * 45 / totalWidth
            if (item.display) {
              switch (item.display) {
                case IMAGE:
                  return <ImageColumn key={rowKey} value={value} width={width}/>
                  break
                case BOOLEAN:
                  return <BoolColumn key={rowKey} isTrue={value} width={width}/>
                  break
                default:
                  return <DefaultColumn key={rowKey} value={value} width={width}/>
                  break
              }
            } else {
              return <DefaultColumn key={rowKey} value={value} width={width}/>
            }
          })

          return (
            <div key={key} className={css.row}>
              <div className={cn(css.numbering, css.col)}>
                <div className={css.content}>{key + 1}</div>
              </div>
              {row}
              <div className={cn(css.col, css.actions)}>
                <div className={css.content}>
                  <TableActions
                    actions={actions}
                    item={bodyItem}
                    reload={reload}
                  />
                </div>
              </div>
            </div>
          )
        })
      }
    </div>
  )
}

export default TableBody
