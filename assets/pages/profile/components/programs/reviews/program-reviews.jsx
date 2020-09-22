import React from 'react'

import {AUTHOR, DATE} from '../../table/header-types'
import {PROGRAM_REVIEWS_URL} from '@/utils/profile/endpoints'
import {PROGRAM_REVIEW} from '../../table/item-types'

import TableTemplate from '../../table/table-template'
import BackBar from '../back-bar'


const headers = [
  {
    title: 'Дата/время',
    type: DATE
  },
  {
    title: 'Автор заявки',
    type: AUTHOR
  },
  {
    title: 'Оценка по параметрам',
    type: null
  },
  {
    title: 'Средняя оценка',
    type: null
  },
  {
    title: 'Отзыв',
    type: null
  },
]

const ProgramReviews = ({match}) => {
  return (
    <div className="container-0 mt-20">
      <BackBar
        title={'Оценки к программе'}
      />

      <TableTemplate
        fetchUrl={PROGRAM_REVIEWS_URL.replace(':id', match.params.id)}
        headers={headers}
        itemType={PROGRAM_REVIEW}
        tableEmptyItem={true}
      />
    </div>
  )
}

export default ProgramReviews
