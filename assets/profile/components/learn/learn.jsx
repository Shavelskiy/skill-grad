import React, {useState, useEffect} from 'react'
import {useHistory, useLocation} from 'react-router-dom'

import axios from 'axios'
import {LEARN_URL} from '../../utils/api/endpoints'

import Table from '../table/table'
import Paginator from '../paginator/paginator'
import Item from './item'
import ReviewModal from './review-modal'

import querystring from 'querystring'


const headers = ['Название программы', 'Категории', 'Образовательная орг-я', 'Дата', 'Оценка']

const Learn = () => {
  const history = useHistory()
  const location = useLocation()

  const queryParams = querystring.parse(location.search.substr(1))

  const [paginatorRequest, setPaginatorRequest] = useState(null)

  const [programs, setPrograms] = useState([])
  const [reviews, setReviews] = useState([])
  const [currentPage, setCurrentPage] = useState('page' in queryParams ? queryParams.page : 1)
  const [totalPages, setTotalPages] = useState(1)
  const [activeModal, setActiveModal] = useState(false)

  const [currentProgramId, setCurrentProgramId] = useState(null)

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

    axios.get(LEARN_URL, {
      cancelToken: axiosSource.token,
      params: {page: currentPage}
    })
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setPrograms(data.programs)
        setReviews(data.reviews)
      })
  }

  return (
    <>
      <Table headers={headers}>
        {
          programs.map((item, key) => {
            return (
              <Item
                key={key}
                program={item}
                review={(item.id in reviews) ? reviews[currentProgramId] : null}
                openReviewModal={() => {
                  setActiveModal(true)
                  setCurrentProgramId(item.id)
                }}
              />
            )
          })
        }
      </Table>

      <Paginator
        currentPage={currentPage}
        totalPages={totalPages}
        click={(page) => setCurrentPage(page)}
      />
      <ReviewModal
        active={activeModal}
        programReview={(currentProgramId in reviews) ? reviews[currentProgramId] : null}
        programId={currentProgramId}
        close={() => setActiveModal(false)}
        reload={() => reload()}
      />
    </>
  )
}

export default Learn
