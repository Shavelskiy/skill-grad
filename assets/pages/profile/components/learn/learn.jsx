import React from 'react'

import { LEARN_URL } from '@/utils/profile/endpoints'

import TableTemplate from '../table/table-template'
import { LEARN } from '../table/item-types'


const headers = [
  {
    title: 'Название программы',
    type: null
  },
  {
    title: 'Категории',
    type: null
  },
  {
    title: 'Образовательная орг-я',
    type: null
  },
  {
    title: 'Дата',
    type: null
  },
  {
    title: 'Оценка',
    type: null
  },
]

const Learn = () => {
  return (
    <TableTemplate
      fetchUrl={LEARN_URL}
      headers={headers}
      itemType={LEARN}
    />
  )
}

export default Learn
