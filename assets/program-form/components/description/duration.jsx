import React, { useState, useEffect } from 'react'

import { useSelector, useDispatch } from 'react-redux'
import { selectDuration } from '../../redux/program/actions'

import { DURATION_HOURS, DURATION_DAYS, OTHER } from '../../utils/field-types'

import RadioButton from '../ui/radio-button'

import css from './duration.scss?module'
import { TextInput, NumberInput } from '../ui/input'


const Duration = () => {
  const dispatch = useDispatch()

  const duration = useSelector(state => state.program.duration)

  const [hourValue, setHourValue] = useState(0)
  const [dayValue, setDayValue] = useState(0)
  const [otherValue, setOtherValue] = useState('')

  useEffect(() => {
    switch (duration.type) {
      case DURATION_HOURS:
        dispatch(selectDuration(DURATION_HOURS, hourValue))
        break
      case DURATION_DAYS:
        dispatch(selectDuration(DURATION_DAYS, dayValue))
        break
      case OTHER:
        dispatch(selectDuration(OTHER, otherValue))
        break
    }
  }, [hourValue, dayValue, otherValue])

  return (
    <>
      <h3>Продолжительность программы обучения:</h3>
      <div>
        <RadioButton
          click={() => dispatch(selectDuration(DURATION_HOURS, hourValue))}
          selected={duration.type === DURATION_HOURS}
        >
          <NumberInput
            standart={true}
            value={hourValue}
            setValue={setHourValue}
          />
          <span className={css.dimension}>ак.ч.</span>
        </RadioButton>
        <RadioButton
          click={() => dispatch(selectDuration(DURATION_DAYS, dayValue))}
          selected={duration.type === DURATION_DAYS}
        >
          <NumberInput
            standart={true}
            value={dayValue}
            setValue={setDayValue}
          />
          <span className={css.dimension}>дней</span>
        </RadioButton>
        <RadioButton
          click={() => dispatch(selectDuration(OTHER, otherValue))}
          selected={duration.type === OTHER}
        >
          <TextInput
            placeholder={'Другой варинт'}
            medium={true}
            value={otherValue}
            setValue={setOtherValue}
          />
        </RadioButton>
      </div>
    </>
  )
}

export default Duration
