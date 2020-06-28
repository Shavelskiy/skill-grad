import React from 'react'

import { ORGANIZAITION } from '../../utils/titles'

import Block from '../ui/block'
import TrainingDays from './training-days'

import css from './organization.scss?module'


const Organization = () => {
  return (
    <Block title={ORGANIZAITION}>
      <div className={css.inputContainer}>
        <TrainingDays/>
      </div>
    </Block>
  )
}

export default Organization
