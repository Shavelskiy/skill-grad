import React, {useState, useEffect} from 'react'

import axios from 'axios'
import {PAYMENTS_BALANCE_URL, PAYMENTS_URL, REPLENISH_URL} from '@/utils/profile/endpoints'
import {PAYMENTS} from '../table/item-types'

import {useDispatch, useSelector} from 'react-redux'
import {setProviderBalance} from '@/pages/profile/redux/actions'

import {Button} from '@/components/react-ui/buttons'
import TableTemplate from '../table/table-template'
import PaymentModal from './payment-modal'

import css from './scss/payments.scss?module'


const headers = [
  {
    title: 'Дата',
    type: null
  },
  {
    title: 'Услуга',
    type: null
  },
  {
    title: 'Итого с НДС (руб.)',
    type: null
  },
  {
    title: 'Номер счет-фактуры',
    type: null
  },
  {
    title: 'Документы',
    type: null
  },
]

const Payments = () => {
  const dispatch = useDispatch()
  const balance = useSelector((state) => state.balance)

  const [paymentModalActive, setPaymentModalActive] = useState(false)

  useEffect(() => {
    axios.get(PAYMENTS_BALANCE_URL)
      .then(({data}) => {
        dispatch(setProviderBalance(data.balance))
      })
  }, [])

  const replenish = (amount) => {
    axios.post(REPLENISH_URL, {amount: amount})
      .then(({data}) => {
        window.open(data.path, '_blank')
        setPaymentModalActive(false)
      })
  }

  return (
    <>
      <div className={css.balance}>
        <h4>Текущий остаток: <strong>{new Intl.NumberFormat('ru-Ru').format(balance)} руб.</strong></h4>
        <Button
          blue={true}
          text={'Пополнить баланс'}
          fullWidth={false}
          click={() => setPaymentModalActive(true)}
        />
      </div>

      <TableTemplate
        fetchUrl={PAYMENTS_URL}
        headers={headers}
        itemType={PAYMENTS}
        tableEmptyItem={true}
      />

      <PaymentModal
        active={paymentModalActive}
        close={() => setPaymentModalActive(false)}
        replenish={replenish}
      />
    </>
  )
}

export default Payments
