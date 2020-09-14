import React, {useEffect, useState} from 'react'
import {useHistory, useLocation} from 'react-router-dom'

import axios from 'axios'
import {LEARN_URL, PROVIDER_PROGRAMS_URL} from '../../utils/api/endpoints'

import Table from '../table/table'
import Navigation from './navigation'
import ProgramItem from './program-item'
import Paginator from '../paginator/paginator'

import css from './programs.scss'
import querystring from 'querystring';

const headers = ['Название программы', 'Категории', 'Заявки', 'Вопросы', 'Оценки']

const Programs = () => {
  const history = useHistory()
  const location = useLocation()

  const queryParams = querystring.parse(location.search.substr(1))

  const [paginatorRequest, setPaginatorRequest] = useState(null)

  const [programs, setPrograms] = useState([])
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

    axios.get(PROVIDER_PROGRAMS_URL, {
      cancelToken: axiosSource.token,
      params: {page: currentPage}
    })
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setPrograms(data.programs)
      })
  }

  return (
    <div className="container-0 mt-20">
      <Navigation/>

      <Table headers={headers} withEmpty={true}>
        {programs.map((program, key) => <ProgramItem key={key} program={program}/>)}
      </Table>

      <Paginator
        currentPage={currentPage}
        totalPages={totalPages}
        click={(page) => setCurrentPage(page)}
      />
    </div>
  )
}

export default Programs
