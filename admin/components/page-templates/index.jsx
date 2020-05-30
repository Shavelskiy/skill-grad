import React, { useState, useEffect } from 'react'
import { useHistory, useLocation } from 'react-router-dom'

import { useSelector, useDispatch } from 'react-redux'
import { setTitle } from '../../redux/actions'

import axios from 'axios'

import Table from '../../components/table/table'
import Paginator from '../../components/paginator/paginator'
import PanelTitle from '../../components/panel/panel-title'

import querystring from 'querystring';


const getInitStateFromUrl = (query) => {
  let initState = {
    page: 1,
    order: {}
  }

  try {
    const queryParams = querystring.parse(query)

    if (typeof queryParams.page !== 'undefined') {
      initState.page = queryParams.page
    }

    if (typeof queryParams.order !== 'undefined') {
      initState.order = JSON.parse(queryParams.order)
    }
  } catch (error) {
  }

  return initState
}

const IndexPageTemplate = ({title, table, actions, fetchUrl, canCreate, createLink}) => {
  const dispatch = useDispatch()
  const history = useHistory()
  const location = useLocation()

  const initState = getInitStateFromUrl(location.search.substr(1))

  const [body, setBody] = useState([])
  const [paginatorRequest, setPaginatorRequest] = useState(null)
  const [disabledTable, setDisabledTable] = useState(false)
  const [totalPages, setTotalPages] = useState(0)
  const [currentPage, setCurrentPage] = useState(initState.page)
  const [order, setOrder] = useState(initState.order)

  useEffect(() => {
    dispatch(setTitle(title))
  }, [])

  useEffect(() => loadItems(), [currentPage, order])

  const loadItems = () => {
    const axiosSource = axios.CancelToken.source()

    if (paginatorRequest) {
      paginatorRequest.cancel()
    }

    setPaginatorRequest({cancel: axiosSource.cancel})
    setDisabledTable(true)

    const params = {
      page: currentPage,
      order: JSON.stringify(order),
    }

    history.push({
      pathname: history.pathname,
      search: `?${querystring.stringify(params)}`
    })

    axios.get(fetchUrl, {
      cancelToken: axiosSource.token,
      params: params,
    })
      .then(({data}) => {
        setBody(data.items)
        setTotalPages(data.total_pages)
        setCurrentPage(data.current_page)
        setDisabledTable(false)
      })
  }

  const changePage = (page) => {
    if (page === currentPage) {
      return
    }

    setCurrentPage(page)
  }

  const changeOrder = (field) => {
    if (order[field] === 'desc') {
      setOrder({})
    } else if (order[field] === 'asc') {
      setOrder({[field]: 'desc'})
    } else {
      setOrder({[field]: 'asc'})
    }
  }

  return (
    <div className="portlet">
      <PanelTitle
        title={title}
        icon={'fa fa-tags'}
        withButton={canCreate}
        buttonLink={createLink}
      />

      <div className="body">
        <Table
          table={table}
          body={body}
          order={order}
          reload={() => loadItems()}
          disabled={disabledTable}
          changeOrder={(propName) => changeOrder(propName)}
          actions={actions}
        />
        <Paginator
          totalPages={totalPages}
          currentPage={currentPage}
          click={(page) => changePage(page)}
        />
      </div>
    </div>
  )
}

export default IndexPageTemplate
