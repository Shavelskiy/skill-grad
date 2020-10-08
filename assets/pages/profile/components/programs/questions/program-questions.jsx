import React from 'react'
import { AUTHOR, DATE } from '../../table/header-types'
import { PROGRAM_QUESTIONS_URL } from '@/utils/profile/endpoints'
import { PROGRAM_QUESTION } from '../../table/item-types'

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
    title: 'Вопрос',
    type: null
  },
]

const ProgramQuestions = ({match}) => {
  return (
    <div className="container-0 mt-20">
      <BackBar
        title={'Вопросы к программе'}
      />

      <TableTemplate
        fetchUrl={PROGRAM_QUESTIONS_URL.replace(':id', match.params.id)}
        headers={headers}
        itemType={PROGRAM_QUESTION}
        tableEmptyItem={true}
      />
    </div>
  )
}

export default ProgramQuestions
