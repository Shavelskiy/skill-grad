import React, { useState, useEffect } from 'react'

import axios from 'axios'
import { PROGRAM_PRICES_URL, PROVIDER_PROGRAMS_URL, PAYMENTS_BALANCE_URL } from '@/utils/profile/endpoints'

import { useDispatch } from 'react-redux'
import { setProgramPrices, setProviderBalance } from '../../../redux/actions'

import { PROGRAM } from '../../table/item-types'

import TableTemplate from '../../table/table-template'
import Navigation from './navigation'


const headers = [
  {
    title: 'Название программы',
    type: null
  },
  {
    title: 'Категории',
    type: null
  },
  {
    title: 'Заявки',
    type: null
  },
  {
    title: 'Вопросы',
    type: null
  },
  {
    title: 'Оценка',
    type: null
  },
]

const Programs = () => {
  const [activeTab, setActiveTab] = useState(true)

  const dispatch = useDispatch()

  useEffect(() => {
    axios.get(PROGRAM_PRICES_URL)
      .then(({data}) => {
        dispatch(setProgramPrices(data))
      })

    axios.get(PAYMENTS_BALANCE_URL)
      .then(({data}) => {
        dispatch(setProviderBalance(data.balance))
      })
  }, [])

  return (
    <div className="container-0 mt-20">
      <Navigation
        activeTab={activeTab}
        setActiveTab={setActiveTab}
      />

      <TableTemplate
        fetchUrl={PROVIDER_PROGRAMS_URL}
        headers={headers}
        itemType={PROGRAM}
        tableEmptyItem={true}
        additionalParams={{active: activeTab ? 1 : 0}}
      />
    </div>
  )
}

export default Programs
