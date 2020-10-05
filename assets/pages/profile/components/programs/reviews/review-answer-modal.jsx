import React, {useState} from 'react'

import {Button} from '@/components/react-ui/buttons'
import Modal from '../../../components/modal/modal'

import {Textarea} from '@/components/react-ui/input';

import css from './scss/review-answer-modal.scss?module'


const ReviewAnswerModal = ({active, close, sendAnswer}) => {
  const [answer, setAnswer] = useState('')
  const [error, setError] = useState('')

  const handleClick = () => {
    setError('')

    if (answer.length < 5) {
      setError('Ответ слишком короткий')
      return
    }

    sendAnswer(answer)
  }

  return (
    <Modal
      active={active}
      close={close}
      error={error}
      title={'Ответить на отзыв'}
    >
      <div className={css.reviewAnswerModal}>
        <Textarea
          placeholder={'Введите текст ответа'}
          value={answer}
          setValue={setAnswer}
          rows={10}
        />
      </div>

      <Button
        text={'Отправить ответ'}
        blue={true}
        click={handleClick}
      />
    </Modal>
  )
}

export default ReviewAnswerModal
