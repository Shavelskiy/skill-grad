import React from 'react'
import {DATE} from '../../table/header-types'
import {PROGRAM_QUESTIONS_URL} from '../../../utils/api/endpoints'
import {PROGRAM_QUESTION} from '../../table/item-types'
import TableTemplate from '../../table/table-template'


const headers = [
  {
    title: 'Дата/время',
    type: DATE
  },
  {
    title: 'Автор заявки',
    type: null
  },
  {
    title: 'Вопрос',
    type: null
  },
]

const ProgramQuestions = ({match}) => {
  return (
    <>
      <div className="container-0 table-programs questions mt-20">
        <h3 className="result-title">
						<span className="back">
							<i className="icon-left"></i>
							<span className="back-text">Вернуться<br/>к программам</span>
						</span>
          Вопросы к программе «Производственный менеджмент»
        </h3>
        <TableTemplate
          fetchUrl={PROGRAM_QUESTIONS_URL.replace(':id', match.params.id)}
          headers={headers}
          itemType={PROGRAM_QUESTION}
          tableEmptyItem={true}
        />
      </div>
    </>
  )
}

export default ProgramQuestions
