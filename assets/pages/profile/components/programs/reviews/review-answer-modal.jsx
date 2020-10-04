import React, {useState} from 'react'

import {Button} from '@/components/react-ui/buttons'
import Modal from '../../../components/modal/modal'

import {Textarea} from '@/components/react-ui/input';


const ReviewAnswerModal = ({active, close}) => {
  const [answer, setAnswer] = useState('')

  return (
    <Modal
      active={active}
      close={close}
      title={'Ответить на отзыв'}
    >
      <Textarea
        placeholder={'Введите текст ответа'}
        value={answer}
        setValue={setAnswer}
        rows={10}
      />

      <Button
        text={'Отправить ответ'}
        blue={true}
        click={() => console.log('kek')}
      />
    </Modal>
  )
}

export default ReviewAnswerModal
