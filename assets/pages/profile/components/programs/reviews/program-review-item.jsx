import React, {useState} from 'react'
import {dateFormat, timeFormat} from '@/helpers/date-formater'

import {useSelector} from 'react-redux'

import ReviewAnswerModal from './review-answer-modal'
import ProAccountModal from './pro-account-modal';

import commonCss from './../common.scss?module'
import css from './scss/program-review-item.scss?module'
import cn from 'classnames'

const ProgramReviewItem = ({review, reload}) => {
  const proAccount = useSelector((state) => state.proAccount)

  const [showFull, setShowFull] = useState(false)

  const [reviewAnswerModalActive, setReviewAnswerModalActive] = useState(false)

  const renderActionButton = () => {
    if (review.answer !== null) {
      return (
        <div className={commonCss.supported}>
          На отзыв дан ответ <i className="icon-correct"></i>
        </div>
      )
    }

    return (
      <div className={commonCss.buttons}>
        <button className={commonCss.buttonB} onClick={() => setReviewAnswerModalActive(true)}>
          Ответить
        </button>
      </div>
    )
  }

  const renderRatingValue = (value, tooltip) => {
    return (
      <span>
        {value}
        <span className={css.tooltip}>{tooltip}</span>
      </span>
    )
  }

  const renderOpenFullReviewButton = () => {
    if (review.review.length < 200) {
      return <></>
    }

    if (showFull) {
      return <span className={css.showMoreButton} onClick={() => setShowFull(false)}>&nbsp;Скрыть отзыв</span>
    }

    return <span className={css.showMoreButton} onClick={() => setShowFull(true)}>&nbsp;Показать полностью</span>
  }

  return (
    <tr>
      <td>{dateFormat(new Date(review.date))} <br/> {timeFormat(new Date(review.date))}</td>
      <td className={commonCss.nameBlock}>
        <span>{review.user_name}</span>
      </td>
      <td className={css.reviews}>
        <div className={css.value}>
          <div className={css.text}>
            <span className={css.title}>Программа</span>
            {renderRatingValue(review.rating[0][0], 'Программа полностью соответствовала поставленным задачам обучения')}
            {renderRatingValue(review.rating[0][1], 'Полученные знания, навыки будут использованы мною в рабочей практике')}
            {renderRatingValue(review.rating[0][2], 'Качество контентного сопровождения до и после обучения очень высокое (ответы на вопросы, консультации, предварительные задания, поддержка после обучения и т.д.)')}
          </div>
          <div className={css.text}>
            <span className={css.title}>Преподаватель</span>
            {renderRatingValue(review.rating[1][0], 'Преподаватель является экспертом в заявленной теме')}
          </div>
          <div className={css.text}>
            <span className={css.title}>Организация<br/>обучения </span>
            {renderRatingValue(review.rating[2][0], 'Раздаточные материалы программы понятны')}
            {renderRatingValue(review.rating[2][1], 'Качество технического сопровождения (информирование, регистрация, навигация, аудитория, техническая поддержка) соотвествует высокому уровню')}
          </div>
        </div>
      </td>
      <td>
        <strong className={cn('accent', css.averageText)}>{review.average_rating}</strong>
      </td>
      <td>
          <span className={css.reviewsText}>
            {showFull ? review.review : review.review.substring(0, 200)}
            {renderOpenFullReviewButton()}
          </span>
      </td>
      <td>
        {renderActionButton()}

        <ReviewAnswerModal
          active={reviewAnswerModalActive && proAccount}
          close={() => setReviewAnswerModalActive(false)}
        />

        <ProAccountModal
          active={reviewAnswerModalActive && !proAccount}
          close={() => setReviewAnswerModalActive(false)}
        />
      </td>
    </tr>
  )
}

export default ProgramReviewItem