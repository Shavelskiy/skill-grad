import React, {useEffect, useState} from 'react'
import {useHistory, useLocation} from 'react-router-dom'

import querystring from 'querystring'
import axios from 'axios'

import { useDispatch } from 'react-redux'
import { setProgramTitle } from '../../redux/actions'

import {LEARN, PROGRAM, PROGRAM_REQUEST, PROGRAM_QUESTION, PROGRAM_REVIEW} from './item-types'

import Table from './table'
import Paginator from '../paginator/paginator'
import ProgramItem from '../programs/list/program-item'
import ProgramRequestItem from '../programs/requests/program-request-item'
import ProgramQuestionItem from '../programs/questions/program-question-item'
import ProgramReviewItem from '../programs/reviews/program-review-item'
import LearnItem from '../learn/item';


const TableTemplate = ({fetchUrl, headers, itemType, tableEmptyItem = false}) => {
  const history = useHistory()
  const location = useLocation()
  const dispatch = useDispatch()

  const queryParams = querystring.parse(location.search.substr(1))

  const [paginatorRequest, setPaginatorRequest] = useState(null)

  const [items, setItems] = useState([])
  const [currentPage, setCurrentPage] = useState('page' in queryParams ? queryParams.page : 1)
  const [totalPages, setTotalPages] = useState(1)


  useEffect(() => {
    reload()
  }, [currentPage])

  const reload = () => {
    const axiosSource = axios.CancelToken.source()

    if (paginatorRequest) {
      paginatorRequest.cancel()
    }

    setPaginatorRequest({cancel: axiosSource.cancel})

    history.push({
      pathname: history.pathname,
      search: `?page=${currentPage}`
    })

    axios.get(fetchUrl, {
      cancelToken: axiosSource.token,
      params: {page: currentPage}
    })
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setItems(data.items)

        if ('program_title' in data) {
          dispatch(setProgramTitle(data.program_title))
        }
      })
  }

  const renderItem = (item, key) => {
    switch (itemType) {
      case LEARN:
        return <LearnItem key={key} program={item} reload={reload}/>
      case PROGRAM:
        return <ProgramItem key={key} program={item}/>
      case PROGRAM_REQUEST:
        return <ProgramRequestItem key={key} request={item} reload={reload}/>
      case PROGRAM_QUESTION:
        return <ProgramQuestionItem key={key} question={item} reload={reload}/>
      case PROGRAM_REVIEW:
        return <ProgramReviewItem key={key} review={item} reload={reload}/>
    }
  }

  return (
    <>
      <Table headers={headers} withEmpty={tableEmptyItem}>
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