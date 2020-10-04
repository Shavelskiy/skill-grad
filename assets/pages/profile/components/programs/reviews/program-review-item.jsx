import React from 'react'
import {dateFormat, timeFormat} from '@/helpers/date-formater'

import commonCss from './../common.scss?module'
import css from './program-review-item.scss?module'
import cn from 'classnames'

const ProgramReviewItem = ({review, reload}) => {
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
        <button className={commonCss.buttonB}>Ответить</button>
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
          <span className="reviews-text">
            {review.review}
            <a className="hide-desktop" href="#">Скрыть отзыв</a>
          </span>
      </td>
      <td>
        {renderActionButton()}
      </td>
    </tr>
  )
}

export default ProgramReviewItem