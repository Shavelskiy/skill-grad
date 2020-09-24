import React from 'react'

import {PAYMENTS_URL} from '@/utils/profile/endpoints'
import {PAYMENTS} from '../table/item-types'

import {Button} from '@/components/react-ui/buttons'
import TableTemplate from '../table/table-template'

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
  return (
    <>
      <div className={css.balance}>
        <h4>Текущий остаток: <strong>1837,00 руб.</strong></h4>
        <Button
          blue={true}
          text={'Пополнить баланс'}
          fullWidth={false}
          click={() => console.warn('todo open balance popup')}
        />
      </div>
      <TableTemplate
        fetchUrl={PAYMENTS_URL}
        headers={headers}
        itemType={PAYMENTS}
        tableEmptyItem={true}
      />
    </>
  )
}

export default Payments
