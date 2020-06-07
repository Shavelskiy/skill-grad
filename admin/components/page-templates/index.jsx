import React, { useState, useEffect } from 'react'
import { useHistory, useLocation } from 'react-router-dom'

import { useDispatch } from 'react-redux'
import { setTitle } from '../../redux/actions'

import axios from 'axios'

import Table from '../../components/table/table'
import Paginator from '../../components/paginator/paginator'
import Portlet from '../portlet/portlet'
import Button from '../ui/button'
import PageCountSelect, { DEFAULT_PAGE_ITEMS } from './page-count-select'

import querystring from 'querystring'
import { getInitStateFromUrl } from './helpers'

import css from './index.scss?module'


const IndexPageTemplate = ({title, icon, table, actions, fetchUrl, canCreate, createLink}) => {
  const dispatch = useDispatch()
  const history = useHistory()
  const location = useLocation()

  const initState = getInitStateFromUrl(location.search.substr(1))

  const [body, setBody] = useState([])
  const [paginatorRequest, setPaginatorRequest] = useState(null)
  const [disabledTable, setDisabledTable] = useState(false)

  const [totalPages, setTotalPages] = useState(0)
  const [currentPage, setCurrentPage] = useState(initState.page)

  const [query, setQuery] = useState({
    pageItemCount: initState.pageItemCount,
    order: initState.order,
    search: initState.search
  })

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

      if (JSON.stringify(query.order) !== JSON.stringify({})) {
        params.order = JSON.stringify(query.order)
      }

      if (JSON.stringify(query.search) !== JSON.stringify({})) {
        params.search = JSON.stringify(query.search)
      }

      if (query.pageItemCount !== DEFAULT_PAGE_ITEMS) {
        params.pageItemCount = query.pageItemCount
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
  }, [query, currentPage, reloadTable])

  const clearSerach = () => {
    if (JSON.stringify(query.search) === JSON.stringify({})) {
      return
    }

    setQuery({...query, search: {}, order: {}})
  }

  return (
    <Portlet
      title={title}
      titleIcon={icon}
      withButton={canCreate}
      buttonLink={createLink}
    >
      <div className={css.settingsWrap}>
        <PageCountSelect
          value={query.pageItemCount}
          setValue={(pageItemCount) => {
            setQuery({...query, pageItemCount: pageItemCount})
            setCurrentPage(1)
          }}
        />
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
        query={query}
        actions={actions}
        reload={() => setReloadTable(!reloadTable)}
        changeSearch={(search) => setQuery({...query, search: search})}
        changeOrder={(order) => setQuery({...query, order: order})}
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
