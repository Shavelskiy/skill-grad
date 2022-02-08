import React from 'react'

import { DATE, AUTHOR, CONTACT } from '../../table/header-types'
import { PROGRAM_REQUEST } from '../../table/item-types'
import { PROGRAM_REQUESTS_URL } from '@/utils/profile/endpoints'

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
    title: 'Контакты',
    type: CONTACT
  },
  {
    title: 'Комментарий',
    type: null
  },
]

const ProgramRequests = ({match}) => {
  return (
    <div className="container-0 mt-20">
      <BackBar
        title={'Заявки к программе'}
      />

      <TableTemplate
        fetchUrl={PROGRAM_REQUESTS_URL.replace(':id', match.params.id)}
        headers={headers}
        itemType={PROGRAM_REQUEST}
        tableEmptyItem={true}
      />
    </div>
  )
}

export default ProgramRequests
