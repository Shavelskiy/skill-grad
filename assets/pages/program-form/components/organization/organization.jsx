import React from 'react'

import { ORGANIZATION } from '@/utils/program-form/titles'

import { useDispatch, useSelector } from 'react-redux'
import { selectInclude, setLocation } from '../../redux/program/actions'
import { focusOrganization } from './../../redux/validation/actions'

import { validateOccupationMode, validateTrainingDate } from '@/helpers/validate-program-form'

import Block from '@/components/react-ui/program-form/block'
import { Textarea } from '@/components/react-ui/program-form/input'
import SimpleMultiRadio from '@/components/react-ui/program-form/simple-multi-radio'

import TrainingDays from './training-days'
import OccupationMode from './occupation-mode'

import css from './scss/organization.scss?module'


const Organization = () => {
  const dispatch = useDispatch()

  const blockActive = useSelector((state) => state.validation.organization.active)
  const program = useSelector(state => state.program)

  return (
    <Block title={ORGANIZATION} containerClass={css.container} onFocus={focusOrganization}>
      <div>
        <TrainingDays error={blockActive && !validateTrainingDate(program)}/>
      </div>

      <div className={css.modeContainer}>
        <OccupationMode error={blockActive && !validateOccupationMode(program)}/>
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
