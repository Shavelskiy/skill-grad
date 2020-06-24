import React from 'react'

import css from './progress-bar.scss?module'
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


const ProgressBar = () => {
  return (
    <div className={css.progressBar}>
      <span>01 {DESCRIPTION}</span>
      <span>02 {DESIGN}</span>
      <span>03 {PROVIDERS}</span>
      <span>04 {LISTENERS}</span>
      <span>05 {RESULTS}</span>
      <span>06 {ORGANIZAITION}</span>
      <span>07 {TERM_OF_USE}</span>
      <span>08 {GALLERY}</span>
      <span>09 {LOCATIONS}</span>
      <span>10 {ADDITIONAL_INFO}</span>
    </div>
  )
}

export default ProgressBar
