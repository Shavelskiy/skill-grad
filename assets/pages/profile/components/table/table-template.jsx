import React, { useEffect, useState } from 'react'
import { useHistory, useLocation } from 'react-router-dom'

import querystring from 'querystring'
import axios from 'axios'

import { useDispatch } from 'react-redux'
import { setProgramTitle } from '../../redux/actions'

import { LEARN, PROGRAM, PROGRAM_REQUEST, PROGRAM_QUESTION, PROGRAM_REVIEW, PAYMENTS } from './item-types'

import Table from './table'
import Paginator from '../paginator/paginator'
import ProgramItem from '../programs/list/program-item'
import ProgramRequestItem from '../programs/requests/program-request-item'
import ProgramQuestionItem from '../programs/questions/program-question-item'
import ProgramReviewItem from '../programs/reviews/program-review-item'
import LearnItem from '../learn/item'
import PaymentItem from '../payments/payment-item'


const TableTemplate = ({fetchUrl, headers, itemType, tableEmptyItem = false, additionalParams = {}}) => {
  const history = useHistory()
  const location = useLocation()
  const dispatch = useDispatch()

  const queryParams = querystring.parse(location.search.substr(1))

  const [paginatorRequest, setPaginatorRequest] = useState(false)
  const [oldAdditionalParams, setOldAdditionalParams] = useState(additionalParams)

  const [items, setItems] = useState([])
  const [currentPage, setCurrentPage] = useState('page' in queryParams ? queryParams.page : 1)
  const [totalPages, setTotalPages] = useState(1)

  useEffect(() => {
    reload()
  }, [currentPage, oldAdditionalParams])

  useEffect(() => {
    if (JSON.stringify(additionalParams) !== JSON.stringify(oldAdditionalParams)) {
      setOldAdditionalParams(additionalParams)
      setCurrentPage(1)
    }
  }, [additionalParams])

  const reload = () => {
    const axiosSource = axios.CancelToken.source()

    if (paginatorRequest) {
      return
    }

    setPaginatorRequest(true)

    history.push({
      pathname: history.pathname,
      search: `?page=${currentPage}`
    })

    axios.get(fetchUrl, {
      cancelToken: axiosSource.token,
      params: {...additionalParams, page: currentPage}
    })
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setItems(data.items)

        if ('program_title' in data) {
          dispatch(setProgramTitle(data.program_title))
        }
      })
      .finally(() => setPaginatorRequest(false))
  }

  const renderItem = (item, key) => {
    switch (itemType) {
      case LEARN:
        return <LearnItem key={key} program={item} reload={reload}/>
      case PROGRAM:
        return <ProgramItem key={key} program={item} reload={reload}/>
      case PROGRAM_REQUEST:
        return <ProgramRequestItem key={key} request={item} reload={reload}/>
      case PROGRAM_QUESTION:
        return <ProgramQuestionItem key={key} question={item} reload={reload}/>
      case PROGRAM_REVIEW:
        return <ProgramReviewItem key={key} review={item} reload={reload}/>
      case PAYMENTS:
        return <PaymentItem key={key} item={item}/>
    }
  }

  const renderEmptyBody = () => {
    if (items.length > 0) {
      return <></>
    }

    return (
      <tr>
        <td>Данные на данный момент отсутсвуют</td>
      </tr>
    )
  }

  return (
    <>
      <Table headers={headers} withEmpty={tableEmptyItem}>
        {renderEmptyBody()}
        {items.map((item, key) => renderItem(item, key))}
      </Table>

      <Paginator
        currentPage={currentPage}
        totalPages={totalPages}
        click={(page) => setCurrentPage(page)}
      />
    </>
  )
}

export default TableTemplate
