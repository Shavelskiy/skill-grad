import React, { useState } from 'react'
import Modal from '../../modal/modal'


const AnswerModal = ({active, question, answer, changeAnswer, close, submit}) => {
  const [error, setError] = useState('')

  const submitAction = () => {
    setError('')

    if (answer.length < 1) {
      setError('Введите ответ')
      return
    }

    submit()
  }

  return (
    <Modal
      active={active}
      close={close}
      title={'Ответ на вопрос'}
      error={error}
    >
      <p className="text">
        <strong className="blue">Вопрос</strong> : {question.question}
      </p>
      <div className="textarea-box">
        <textarea
          className="textarea"
          rows="5"
          placeholder="Введите текст ответа"
          value={answer}
          onChange={(event) => changeAnswer(event.target.value)}
        ></textarea>
      </div>
      <button className="button-red" onClick={submitAction}>Отправить ответ</button>
    </Modal>
  )
}

export default AnswerModal
