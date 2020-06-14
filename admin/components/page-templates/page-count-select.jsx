import React, { useEffect } from 'react'

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

export const DEFAULT_PAGE_ITEMS = 20

const PageCountSelect = ({value, setValue}) => {
  useEffect(() => {
    const valueInOptions = options.filter((item) => {
      return item.value === value
    }).length > 0

    if (!valueInOptions) {
      setValue(DEFAULT_PAGE_ITEMS)
    }
  }, [])

  return (
    <div className={css.select}>
      <label>На странице:</label>
      <Select
        options={options}
        canUncheck={false}
        value={value}
        setValue={setValue}
        small={true}
        low={true}
      />
    </div>
  )
}

export default PageCountSelect
