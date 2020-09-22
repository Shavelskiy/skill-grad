import React, {useState} from 'react'

import axios from 'axios'
import {ADD_REVIEW_URL} from '../../utils/api/endpoints'

import {dateFormat} from '../../helpers/date-fromater'
import ReviewModal from './review-modal'

import css from './scss/item.scss?module'


const LearnItem = ({program, reload}) => {
  const [activeReviewModal, setActiveReviewModal] = useState(false)
  const [newReview, setNewReview] = useState({
    rating: [[0, 0, 0], [0], [0, 0]],
    review: '',
  })

  const saveReview = () => {
    axios.post(ADD_REVIEW_URL, {
      id: program.id,
      review: newReview
    })
      .then(() => {
        reload()
        setActiveReviewModal(false)
      })
  }

  const renderReviewButton = () => {
    if (program.review === null) {
      return (
        <button className={css.button} onClick={() => setActiveReviewModal(true)}>Оставить оценку</button>
      )
    }

    return (
      <div className="success-block">
        <div className={css.success}>
          <span>Оценка поставлена</span>
          <i className="icon-correct"></i>
        </div>
        <a onClick={() => setActiveReviewModal(true)}>посмотреть</a>
      </div>
    )
  }

  return (
    <tr>
      <td>
        <a className="title-link" href={program.link} target="_blank">
          {program.name}
        </a>
      </td>
      <td>{program.categories}</td>
      <td>
        <a href={program.provider.link} target="_blank">{program.provider.name}</a>
      </td>
      <td><span className="date">{dateFormat(new Date(program.date))}</span></td>
      <td>
        {renderReviewButton()}
        <ReviewModal
          active={activeReviewModal}
          close={() => setActiveReviewModal(false)}
          reload={reload}
          review={program.review !== null ? program.review : newReview}
          setReview={setNewReview}
          isNew={program.review === null}
          submit={saveReview}
        />
      </td>
    </tr>
  )
}

export default LearnItem
