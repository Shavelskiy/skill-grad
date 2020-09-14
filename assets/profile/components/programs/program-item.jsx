import React from 'react'

import css from './program-item.scss?module'
import cn from 'classnames'

const ProgramItem = ({program}) => {
  return (
    <tr>
      <td className={css.programFirstColumn}>
        <a href={program.link} target="_blank">{program.name}</a>
      </td>
      <td className="mobile-p-b">
        <span className={css.categories}>{program.categories}</span>
      </td>
      <td className="col-sm-1">
        {/*<strong className="accent mobile">Заявки</strong>*/}
        <div className={css.iconButton}>
          <span className={cn('icon', 'mail')}></span>
          <span className={css.buttonNotification}>12</span>
        </div>
        <p className={css.iconTotalText}>
          Всего: {program.requests.total}
        </p>
      </td>
      <td className="col-sm-1">
        {/*<strong className="accent mobile">Вопросы</strong>*/}
        <div className={css.iconButton}>
          <span className={cn('icon', 'mail')}></span>
          <span className={css.buttonNotification}>12</span>
        </div>
        <p className={css.iconTotalText}>
          Всего: {program.questions.total}
        </p>
      </td>
      <td className="col-sm-1">
        {/*<strong className="accent mobile">Оценки</strong>*/}
        <div className={css.iconButton}>
          <span className="icon email-f small"></span>
        </div>
        <p className={css.iconTotalText}>
          Всего: {program.requests.total}
        </p>
      </td>
      <td>
        <div className={css.actions}>
          <span className={cn('icon', 'goal', css.item)}></span>
          <span className={cn('icon', 'status', css.item)}></span>
          <span className={cn('icon', 'pencil', css.item)}></span>
          <span className={cn('icon', 'delete', css.item)}></span>
        </div>
      </td>
    </tr>
  )
}

export default ProgramItem

// <tr>
// <td>
// <a className="title-link" href="/pages/card-program.html">
//   Маркетинг (многопрофильный бакалавриат «Маркетинг и управление продажами»)
// </a>
// </td>
// <td className="mobile-p-b">
// <a href="#">Маркетинг,</a>
// <a href="#">Офис, </a>
// <a href="#">Управление и бизнес</a>
// </td>
// <td className="col-sm-1">
// <strong className="accent mobile">Заявки</strong>
// <div data-name="applications" className="icon-button">
// <span className="icon mail"></span>
// <span className="button-notification">12</span>
// </div>
// <p className="text nowrap">
// Всего: 121
// </p>
// </td>
// <td className="col-sm-1">
// <strong className="accent mobile">Вопросы</strong>
// <div data-name="questions" className="icon-button">
// <span className="icon mail"></span>
// <span className="button-notification">12</span>
// </div>
// <p className="text nowrap">
// Всего: 121
// </p>
// </td>
// <td className="col-sm-1">
// <strong className="accent mobile">Оценки</strong>
// <div data-name="assessment" className="icon-button">
// <span className="icon email-f"></span>
// </div>
// <p className="text nowrap">
// Всего: 121
// </p>
// </td>
// <td>
// <div className="rules d-flex">
// <span className="open-pay-service icon goal"></span>
// <span data-tippy-content="Опубликовать программу"
// className="open-deactivate icon not status"></span>
// <i className="open-no-balance icon-pencil">
// <span className="path1"></span>
// <span className="path2"></span>
// <span className="path3"></span>
// </i>
// <span className="delete open-delete"></span>
// </div>
// </td>
// </tr>