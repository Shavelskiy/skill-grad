import React, { useState, useEffect } from 'react'

import { useSelector, useDispatch } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import axios from 'axios'

import Table from '../../components/table/table'
import Paginator from '../../components/paginator/paginator'
import Search from '../../components/search/search'
import PanelTitle from '../../components/panel/panel-title'


const IndexPageTemplate = ({title, table, actions, fetchUrl, canCreate, createLink}) => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(setTitle(title))
    dispatch(setBreacrumbs([]))
  }, [])

  const [body, setBody] = useState([])
  const [paginatorRequest, setPaginatorRequest] = useState(null)
  const [disabledTable, setDisabledTable] = useState(false)
  const [totalPages, setTotalPages] = useState(0)
  const [currentPage, setCurrentPage] = useState(1)
  const [order, setOrder] = useState({})

  useEffect(() => loadItems(), [])

  const loadItems = () => {
    const axiosSource = axios.CancelToken.source()

    if (paginatorRequest) {
      paginatorRequest.cancel()
    }

    setPaginatorRequest({cancel: axiosSource.cancel})
    setDisabledTable(true)

    const params = {
      page: currentPage,
      order: order,
    }

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
    loadItems()
  }

  const changeOrder = (propName) => {
    if (!order[propName]) {
      order[propName] = null
    }

    switch (order[propName]) {
      case null:
        order[propName] = 'asc'
        break
      case 'asc':
        order[propName] = 'desc'
        break
      case 'desc':
        delete order[propName]
        break
    }

    setOrder(order)
    loadItems()
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
        {/*<Search/>*/}
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
