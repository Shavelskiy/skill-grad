import React from 'react'

import css from './progress-bar.scss?module'

const ProgressBar = () => {
  return (
    <div className={css.progressBar}>
      <span>01 Описание программы обучения</span>
      <span>02 Дизайн программы обучения</span>
      <span>03 Провайдер обучения</span>
      <span>04 Слушатели программы</span>
      <span>05 Результаты обучения</span>
      <span>06 Организационные вопросы</span>
      <span>07 Условия участия</span>
      <span>08 Фотографии с мероприятия</span>
      <span>09 В каких городах показывать программу</span>
      <span>10 Дополнительная информация</span>
    </div>
  )
}

export default ProgressBar
