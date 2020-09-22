import React from 'react'

import { ORGANIZATION } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { selectInclude, setLocation } from '../../redux/program/actions'

import Block from '../ui/block'
import TrainingDays from './training-days'
import OccupationMode from './occupation-mode'
import { Textarea } from '../ui/input'
import SimpleMultiRadio from '../ui/simple-multi-radio'

import css from './scss/organization.scss?module'


const Organization = () => {
  const dispatch = useDispatch()

  return (
    <Block title={ORGANIZATION} containerClass={css.container}>
      <div>
        <TrainingDays/>
      </div>

      <div className={css.modeContainer}>
        <OccupationMode/>
      </div>

      <div className={css.locationContainer}>
        <Textarea
          placeholder={'Место проведения'}
          value={useSelector(state => state.program.location)}
          setValue={(value) => dispatch(setLocation(value))}
        />
      </div>

      <div className={css.includeContainer}>
        <SimpleMultiRadio
          title={'Включено в курс'}
          options={useSelector(state => state.data.include)}
          selectedValues={useSelector(state => state.program.include)}
          setValues={selectInclude}
        />
      </div>
    </Block>
  )
}

export default Organization
