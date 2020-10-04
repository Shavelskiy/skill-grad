import React, {useEffect} from 'react'

import {AUTHOR, DATE} from '../../table/header-types'

import axios from 'axios'
import {
  PAYMENTS_BALANCE_URL,
  PROGRAM_REVIEWS_URL,
  PROVIDER_IS_PRO_ACCOUNT,
  PROVIDER_PRO_ACCOUNT_PRICE
} from '@/utils/profile/endpoints'

import {useDispatch} from 'react-redux'
import {setProAccount, setProAccountPrice, setProviderBalance} from '@/pages/profile/redux/actions'

import {PROGRAM_REVIEW} from '../../table/item-types'

import TableTemplate from '../../table/table-template'
import BackBar from '../back-bar'



const headers = [
  {
    title: 'Дата/время',
    type: DATE
  },
  {
    title: 'Автор заявки',
    type: AUTHOR
  },
  {
    title: 'Оценка по параметрам',
    type: null
  },
  {
    title: 'Средняя оценка',
    type: null
  },
  {
    title: 'Отзыв',
    type: null
  },
]

const ProgramReviews = ({match}) => {
  const dispatch = useDispatch()

  useEffect(() => {
    axios.get(PROVIDER_PRO_ACCOUNT_PRICE)
      .then(({data}) => {
        dispatch(setProAccountPrice(data.price))
      })

    axios.get(PAYMENTS_BALANCE_URL)
      .then(({data}) => {
        dispatch(setProviderBalance(data.balance))
      })

    axios.get(PROVIDER_IS_PRO_ACCOUNT)
      .then(({data}) => dispatch(setProAccount(data.is_pro_account)))
  }, [])

  return (
    <div className="container-0 mt-20">
      <BackBar
        title={'Оценки к программе'}
      />

      <TableTemplate
        fetchUrl={PROGRAM_REVIEWS_URL.replace(':id', match.params.id)}
        headers={headers}
        itemType={PROGRAM_REVIEW}
        tableEmptyItem={true}
      />
    </div>
  )
}

export default ProgramReviews
