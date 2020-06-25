import React, { useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { selectDesign } from '../../redux/actions'

import RadioButton from '../ui/radio-button'
import { NumberInput, TextInput } from '../ui/input'

import { DESIGN_SIMPLE, DESIGN_WORK, OTHER } from '../../utils/field-types'

import css from './program-design.scss?module'


const ProgramDesign = () => {
  const dispatch = useDispatch()
  const design = useSelector(state => state.programDesign)

  const [otherValue, setOtherValue] = useState('')
  const [percents, setPercents] = useState([0, 0])

  return (
    <div className={css.container}>
      <h3>Дизайн программы обучения:</h3>
      <div className={css.programDesign}>
        <RadioButton
          click={() => dispatch(selectDesign(DESIGN_SIMPLE, percents))}
          selected={design.type === DESIGN_SIMPLE}
        >
          <div className={css.percentInput}>
            <NumberInput
              small={true}
              value={percents[0]}
              maxValue={99}
              setValue={(value) => setPercents([value, percents[1]])}
            />
            <span>% теории,</span>
          </div>
          <div className={css.percentInput}>
            <NumberInput
              small={true}
              value={percents[1]}
              maxValue={99}
              setValue={(value) => setPercents([percents[0], value])}
            />
            <span>% практики</span>
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
            value={otherValue}
            setValue={(value) => setOtherValue(value)}
          />
        </RadioButton>
      </div>
    </div>
  )
}

export default ProgramDesign
