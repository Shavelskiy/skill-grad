import React from 'react'

import {
  ADDITIONAL_INFO,
  DESCRIPTION,
  DESIGN,
  GALLERY,
  LISTENERS, LOCATIONS,
  ORGANIZAITION,
  PROVIDERS,
  RESULTS,
  TERM_OF_USE
} from '../../utils/titles'

import css from './progress-bar.scss?module'
import cn from 'classnames'


const ProgressBar = () => {
  return (
    <>
      <div className={css.progressBar}>
        <div className={cn(css.item, css.success)}>
          <span className={css.number}>01</span>
          <span className={css.text}>
           {DESCRIPTION}
        </span>
        </div>
        <div className={cn(css.item, css.success)}>
          <span className={css.number}>02</span>
          <span className={css.text}>
           {DESIGN}
        </span>
        </div>
        <div className={cn(css.item, css.success)}>
          <span className={css.number}>03</span>
          <span className={css.text}>
           {PROVIDERS}
        </span>
        </div>
        <div className={cn(css.item, css.error)}>
          <span className={css.number}>04</span>
          <span className={css.text}>
           {LISTENERS}
        </span>
        </div>
        <div className={cn(css.item, css.error)}>
          <span className={css.number}>05</span>
          <span className={css.text}>
           {RESULTS}
        </span>
        </div>
        <div className={css.item}>
          <span className={css.number}>06</span>
          <span className={css.text}>
           {ORGANIZAITION}
        </span>
        </div>
        <div className={css.item}>
          <span className={css.number}>07</span>
          <span className={css.text}>
           {TERM_OF_USE}
        </span>
        </div>
        <div className={css.item}>
          <span className={css.number}>08</span>
          <span className={css.text}>
           {GALLERY}
        </span>
        </div>
        <div className={css.item}>
          <span className={css.number}>09</span>
          <span className={css.text}>
           {LOCATIONS}
        </span>
        </div>
        <div className={css.item}>
          <span className={css.number}>10</span>
          <span className={css.text}>
           {ADDITIONAL_INFO}
        </span>
        </div>
      </div>
      <div className={css.result}>
        Качество описания программы
        <div className={css.tooltip}>
          Чем выше качество описания программы, тем больше шансов, что именно вашу программу выберут и она в большей степени будет соответствовать ожиданиям обучающегося и тем она выше
          в результатах выдачи
        </div>
        <div className={css.percents}>
          <span>100%</span>
        </div>
      </div>
    </>
  )
}

export default ProgressBar
