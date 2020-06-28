import React from 'react'

import { ORGANIZAITION } from '../../utils/titles'

import Block from '../ui/block'
import TrainingDays from './training-days'
import OccupationMode from './occupation-mode'

import css from './organization.scss?module'


const Organization = () => {
  return (
    <Block title={ORGANIZAITION}>
      <div className={css.inputContainer}>
        <TrainingDays/>
      </div>
      <div className={css.inputContainer}>
        <OccupationMode/>
      </div>
    </Block>
  )
}

export default Organization
