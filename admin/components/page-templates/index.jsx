import React, { useState, useEffect } from 'react'
import { useHistory, useLocation } from 'react-router-dom'

import { useSelector, useDispatch } from 'react-redux'
import { setTitle } from '../../redux/actions'

import axios from 'axios'

import Table from '../../components/table/table'
import Paginator from '../../components/paginator/paginator'
import Portlet from '../portlet/portlet'
import Button from '../ui/button'
import PageCountSelect from './page-count-select'

import querystring from 'querystring';
import { getInitStateFromUrl, DEFAULT_PAGE_ITEMS } from './helpers'

import css from './index.scss?module'


const IndexPageTemplate = ({title, table, actions, fetchUrl, canCreate, createLink}) => {
  const dispatch = useDispatch()
  const history = useHistory()
  const location = useLocation()

  const initState = getInitStateFromUrl(location.search.substr(1))

  const [body, setBody] = useState([])
  const [paginatorRequest, setPaginatorRequest] = useState(null)
  const [disabledTable, setDisabledTable] = useState(false)
  const [totalPages, setTotalPages] = useState(0)
  const [pageItemCount, setPageItemCount] = useState(initState.pageItemCount)
  const [currentPage, setCurrentPage] = useState(initState.page)
  const [order, setOrder] = useState(initState.order)
  const [search, setSearch] = useState(initState.search)
  const [reloadTable, setReloadTable] = useState(true)

  useEffect(() => {
    dispatch(setTitle(title))
  }, [])

  useEffect(() => {
    let mounted = true
    const loadItems = async () => {
      const axiosSource = axios.CancelToken.source()

      if (paginatorRequest) {
        paginatorRequest.cancel()
      }

      setPaginatorRequest({cancel: axiosSource.cancel})
      setDisabledTable(true)

      const params = {}

      if (currentPage !== 1) {
        params.page = currentPage
      }

      if (JSON.stringify(order) !== JSON.stringify({})) {
        params.order = JSON.stringify(order)
      }

      if (JSON.stringify(search) !== JSON.stringify({})) {
        params.search = JSON.stringify(search)
      }

      if (pageItemCount !== DEFAULT_PAGE_ITEMS) {
        params.pageItemCount = pageItemCount
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
          if (!mounted) {
            return
          }

          setBody(data.items)
          setTotalPages(data.total_pages)
          setCurrentPage(data.current_page)
          setDisabledTable(false)
        })
    }
    loadItems()

    return () => mounted = false
  }, [currentPage, order, pageItemCount, reloadTable])

  const clearSerach = () => {
    if (JSON.stringify(search) === JSON.stringify({})) {
      return
    }

    setSearch({})
    setReloadTable(!reloadTable)
  }

  return (
    <Portlet
      title={title}
      titleIcon={'tags'}
      withButton={canCreate}
      buttonLink={createLink}
    >
      <div className={css.settingsWrap}>
        <PageCountSelect value={pageItemCount} setValue={setPageItemCount}/>
        <Button
          text="очистить поиск"
          primary={true}
          click={() => clearSerach()}
        />
      </div>
      <Table
        table={table}
        disabled={disabledTable}
        body={body}
        order={order}
        search={search}
        actions={actions}
        reload={() => setReloadTable(!reloadTable)}
        changeSearch={(search) => setSearch(search)}
        changeOrder={(order) => setOrder(order)}
      />
      <Paginator
        totalPages={totalPages}
        currentPage={currentPage}
        click={(page) => {
          (page !== currentPage) ? setCurrentPage(page) : {}
        }}
      />
    </Portlet>
  )
}

export default IndexPageTemplate
