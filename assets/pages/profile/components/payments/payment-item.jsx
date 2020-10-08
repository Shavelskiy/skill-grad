import React from 'react'

import { dateFormat } from '@/helpers/date-formater'

import css from './scss/payment-item.scss?module'
import cn from 'classnames'


const PaymentItem = ({item}) => {
  const renderDocuments = () => {
    return item.documents.map((document, key) => {
      return (
        <td key={key}>
          <a className={css.linkIcon} href={document.path} target={'_blank'}>
            <span className={cn('icon', 'pdf')}></span>
            {document.name}
          </a>
        </td>
      )
    })
  }
  return (
    <tr>
      <td>
        {dateFormat(new Date(item.date))}
      </td>
      <td>
        {item.name}
      </td>
      <td>
        <strong className={css.price}>{new Intl.NumberFormat('ru-Ru').format(item.price)}</strong>
      </td>
      <td>{item.number}</td>
      {renderDocuments()}
      {item.documents.length < 1 ? <td></td> : <></>}
      {item.documents.length < 2 ? <td></td> : <></>}
    </tr>
  )
}

export default PaymentItem
