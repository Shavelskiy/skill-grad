import React from 'react'

import css from './enum-list.scss?module'
import cn from 'classnames'

import deleteImage from './../../img/delete.svg'


const EnumList = ({title, values, setValues}) => {
  const renderList = () => {
    return values.map((item, key) => {
      return (
        <div key={key} className={cn(css.item, css.add)}>
          <span className={cn(css.point, css.number)}>{key + 1}</span>
          <input
            className={css.input}
            value={item}
            onChange={(event) => setValues(values.map((item, itemKey) => (itemKey === key) ? event.target.value : item))}
          />
          <img
            src={deleteImage}
            onClick={() =>  setValues(values.filter((item, itemKey) => itemKey !== key))}
          />
        </div>
      )
    })
  }

  return (
    <>
      <h3>{title}:</h3>
      <div className={css.container}>
        {renderList()}
        <div
          className={cn(css.item, css.add)}
          onClick={() => setValues([...values, ''])}
        >
          <span className={cn(css.point, css.plus)}></span>
          <span className={css.addButton}>Добавить</span>
        </div>
      </div>
    </>
  )
}

export default EnumList
