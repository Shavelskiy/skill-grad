import React, {useState, useEffect} from 'react'

import axios from 'axios'
import {LEARN_URL} from '../../utils/api/endpoints'

import Paginator from '../paginator/paginator'
import Item from './item'
import ReviewModal from './review-modal'


const Learn = () => {
  const [programs, setPrograms] = useState([])
  const [reviews, setReviews] = useState([])
  const [currentPage, setCurrentPage] = useState(1)
  const [totalPages, setTotalPages] = useState(1)
  const [activeModal, setActiveModal] = useState(false)

  const [currentProgramId, setCurrentProgramId] = useState(null)

  useEffect(() => {
    reload()
  }, [])

  const reload = () => {
    axios.get(LEARN_URL)
      .then(({data}) => {
        setCurrentPage(data.page)
        setTotalPages(data.total_pages)
        setPrograms(data.programs)
        setReviews(data.reviews)
      })
  }

  return (
    <>
      <table className="table">
        <thead>
        <tr>
          <th>Название программы</th>
          <th>Категории</th>
          <th>Образовательная орг-я</th>
          <th>Дата</th>
          <th>Оценка</th>
        </tr>
        </thead>
        <tbody>
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
        </tbody>
      </table>
      <Paginator
        currentPage={currentPage}
        totalPages={totalPages}
        click={(page) => console.log(page)}
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
