import React, { useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { selectDesign } from '../../redux/program/actions'

import RadioButton from '@/components/react-ui/program-form/radio-button'
import { NumberInput, TextInput } from '@/components/react-ui/program-form/input'

import { DESIGN_SIMPLE, DESIGN_WORK, OTHER } from '@/utils/program-form/field-types'

import css from './scss/program-design.scss?module'


const ProgramDesign = () => {
  const dispatch = useDispatch()
  const design = useSelector(state => state.program.programDesign)

  const [otherValue, setOtherValue] = useState('')
  const [percents, setPercents] = useState([0, 0])

  return (
    <>
      <h3>Дизайн программы обучения:</h3>
      <div>
        <RadioButton
          click={() => dispatch(selectDesign(DESIGN_SIMPLE, percents))}
          selected={design.type === DESIGN_SIMPLE}
        >
          <div className={css.percentInput}>
            <NumberInput
              extraSmall={true}
              value={percents[0]}
              maxValue={100 - percents[1]}
              setValue={(value) => setPercents([value, percents[1]])}
            />
            <span className={css.theory}>% теории,</span>
          </div>
          <div className={css.percentInput}>
            <NumberInput
              extraSmall={true}
              value={percents[1]}
              maxValue={100 - percents[0]}
              setValue={(value) => setPercents([percents[0], value])}
            />
            <span className={css.practice}>% практики</span>
          </div>
        </RadioButton>
        <RadioButton
          click={() => dispatch(selectDesign(DESIGN_WORK, null))}
          selected={design.type === DESIGN_WORK}
        >
          Работа с наставником (тьютором, преподавателем)
        </RadioButton>
        <RadioButton
          click={() => dispatch(selectDesign(OTHER, otherValue))}
          selected={design.type === OTHER}
        >
          <TextInput
            placeholder={'Другой варинт'}
            medium={true}
            value={otherValue}
            setValue={(value) => setOtherValue(value)}
          />
        </RadioButton>
      </div>
    </>
  )
}

export default ProgramDesign
