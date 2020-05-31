import React from 'react'

import Select from '../ui/select'

import css from './page-count-select.scss?module'


const options = [
  {
    title: '5',
    value: 5,
  },
  {
    title: '10',
    value: 10,
  },
  {
    title: '20',
    value: 20,
  },
  {
    title: '50',
    value: 50,
  },
  {
    title: '100',
    value: 100,
  },
]

const PageCountSelect = ({value, setValue}) => {
  return (
    <div className={css.select}>
      <label>На странице</label>
      <Select
        options={options}
        value={value}
        setValue={setValue}
        small={true}
      />
    </div>
  )
}

export default PageCountSelect
