import React from 'react'

import {DATE, AUTHOR, CONTACT} from '../../table/header-types'
import {PROGRAM_REQUEST} from '../../table/item-types'

import TableTemplate from '../../table/table-template'
import {PROGRAM_REQUESTS_URL} from '../../../utils/api/endpoints';

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
    <div className="container-0 table-programs applications mt-20">
      <h3 className="result-title">
          <span className="back">
            <i className="icon-left"></i>
            <span className="back-text">Вернуться<br/>к программам</span>
          </span>
        Заявки к программе <br className="show-mobile"/> «Производственный менеджмент»
      </h3>
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
