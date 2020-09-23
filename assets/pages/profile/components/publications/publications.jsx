import React, {useEffect, useState} from 'react'
import {useHistory, useLocation} from 'react-router-dom'

import axios from 'axios'
import {ARTICLES_URL} from '@/utils/profile/endpoints'

import PublicationsItem from './publications-item'
import NewArticlePopup from './new-article-popup';
import Paginator from '../paginator/paginator'
import {Button} from '@/components/react-ui/buttons'

import querystring from 'querystring'

import css from './scss/publications.scss?module'


const Publications = () => {
  const history = useHistory()
  const location = useLocation()

  const queryParams = querystring.parse(location.search.substr(1))

  const [paginatorRequest, setPaginatorRequest] = useState(null)

  const [activeNewArticlePopup, seActiveNewArticlePopup] = useState(false)

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

    axios.get(ARTICLES_URL, {
      cancelToken: axiosSource.token,
      params: {page: currentPage}
    })
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setItems(data.items)
      })
  }

  return (
    <div className={css.container}>
      <div className={css.alert}>
        Бесплатно разместите новость или статью о вашей организации или программе
        <Button
          text={'Разместить статью'}
          blue={true}
          click={() => seActiveNewArticlePopup(true)}
        />
      </div>

      {items.map((item, key) => <PublicationsItem key={key} item={item}/>)}

      <Paginator
        currentPage={currentPage}
        totalPages={totalPages}
        click={(page) => setCurrentPage(page)}
      />

      <NewArticlePopup
        active={activeNewArticlePopup}
        close={() => seActiveNewArticlePopup(false)}
      />
    </div>
  )
}

export default Publications
