import React, {useState} from 'react'

import Modal from '../modal/modal'
import {NumberInput} from '@/components/react-ui/input'
import {Button} from '@/components/react-ui/buttons'

import css from './scss/payment-modal.scss?module'


const PaymentModal = ({active, close, replenish}) => {
  const [error, setError] = useState('')
  const [amount, setAmount] = useState('')

  const handleClick = () => {
    setError('')

    if (amount.length < 1) {
      setError('Введите сумму пополнения')
    }

    replenish(amount)
  }

  return (
    <Modal
      active={active}
      close={close}
      title={'Пополнить баланс'}
      error={error}
    >
      <div className={css.paymentModal}>
        <NumberInput
          value={amount}
          setValue={setAmount}
          maxLength={6}
          placeholder={'Сумма пополнения, руб'}
        />

        <Button
          blue={true}
          text={'Получить счет'}
          click={handleClick}
        />
      </div>
    </Modal>
  )
}

export default PaymentModal