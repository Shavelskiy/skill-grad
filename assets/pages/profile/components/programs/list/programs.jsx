import React from 'react'

import {PROVIDER_PROGRAMS_URL} from '@/utils/profile/endpoints'
import {PROGRAM} from '../../table/item-types'

import TableTemplate from '../../table/table-template'
import Navigation from './navigation'


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
    title: 'Заявки',
    type: null
  },
  {
    title: 'Вопросы',
    type: null
  },
  {
    title: 'Оценка',
    type: null
  },
]

const Programs = () => {
  return (
    <div className="container-0 mt-20">
      <Navigation/>

      <TableTemplate
        fetchUrl={PROVIDER_PROGRAMS_URL}
        headers={headers}
        itemType={PROGRAM}
        tableEmptyItem={true}
      />
    </div>
  )
}

export default Programs
