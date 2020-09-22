import React, {useState} from 'react'

import axios from 'axios'
import {QUESTION_ANSWER_URL} from '@/utils/profile/endpoints'

import {dateFormat, timeFormat} from '@/helpers/date-formater'

import AnswerModal from './answer-modal'

import css from './../common.scss?module'
import cn from 'classnames'


const ProgramQuestionItem = ({question, reload}) => {
  const [answerModalActive, setAnswerModalActive] = useState(false)
  const [answer, setAnswer] = useState('')

  const answerAction = () => {
    axios.post(QUESTION_ANSWER_URL.replace(':id', question.id), {
      answer: answer
    })
      .finally(() => {
        setAnswerModalActive(false)
        reload()
      })
  }

  const renderAnswerButton = () => {
    if (question.answer !== null) {
      return (
        <div className={css.supported}>
          Ответ есть <i className="icon-correct"></i>
        </div>
      )
    }

    return (
      <div className={css.buttons}>
        <button className={css.buttonB} onClick={() => setAnswerModalActive(true)}>Ответить</button>
        <AnswerModal
          question={question}
          active={answerModalActive}
          answer={answer}
          changeAnswer={setAnswer}
          submit={answerAction}
          close={() => setAnswerModalActive(false)}
        />
      </div>
    )
  }

  return (
    <tr>
      <td>{dateFormat(new Date(question.date))} <br/> {timeFormat(new Date(question.date))}</td>
      <td className={css.nameBlock}>
        <span>{question.user_name}</span>
      </td>
      <td className={cn(css.qBlock, {[css.active]: question.answer === null})}>
        <p className="text">{question.question}</p>
      </td>
      <td>
        {renderAnswerButton()}
      </td>
    </tr>
  )
}

export default ProgramQuestionItem
