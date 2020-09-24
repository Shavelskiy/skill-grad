import React from 'react'

import css from './scss/payment-item.scss?module'
import cn from 'classnames'


const PaymentItem = ({item}) => {
  return (
    <tr>
      <td>
        12.02.2020
      </td>
      <td>
        Продвижение программы: «Базовые уроки флористики»
      </td>
      <td>
        990.00
      </td>
      <td>8546972-6347895/GH-1</td>
      <td>
        <a className={css.linkIcon} href="#">
          <span className={cn('icon', 'pdf')}></span>
          Счет-фактура
        </a>
      </td>
      <td>
        <a className={css.linkIcon} href="#">
          <span className={cn('icon', 'pdf')}></span>Акт
        </a>
      </td>
    </tr>
  )
}

export default PaymentItem
