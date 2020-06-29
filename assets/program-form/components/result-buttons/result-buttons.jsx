import React from 'react'

import css from './result-buttons.scss?module'
import cn from 'classnames'


const ResultButtons = () => {
  return (
    <div className={css.buttonContainer}>
      <div className={cn(css.button, css.cancel)}>
        Отменить
      </div >
      <div className={cn(css.button, css.save)}>
        Сохранить
      </div>
      <div className={cn(css.button, css.publish)}>
        Опубликовать
      </div>
    </div>
  )
}

export default ResultButtons
