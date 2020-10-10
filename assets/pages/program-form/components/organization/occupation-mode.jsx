import React, { useState, useEffect } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setOccupationMode } from '../../redux/program/actions'

import { OCCUPATION_MODE_ANYTIME, OCCUPATION_MODE_TIME, OTHER } from '@/utils/program-form/field-types'

import RadioButton from '@/components/react-ui/program-form/radio-button'
import { TextInput } from '@/components/react-ui/program-form/input'

import css from './scss/occupation-mode.scss?module'
import cn from 'classnames'


const days = [
  {
    value: 1,
    title: 'пн',
  },
  {
    value: 2,
    title: 'вт',
  },
  {
    value: 3,
    title: 'ср',
  },
  {
    value: 4,
    title: 'чт',
  },
  {
    value: 5,
    title: 'пт',
  },
  {
    value: 6,
    title: 'сб',
  },
  {
    value: 7,
    title: 'вс',
  },
]

const OccupationMode = ({error = false}) => {
  const dispatch = useDispatch()

  const occupationMode = useSelector(state => state.program.occupationMode)

  const [selectedDays, setSelectedDays] = useState([])
  const [selectedTime, setSelectedTime] = useState({
    start: '00:00',
    end: '00:00',
  })
  const [otherValue, setOtherValue] = useState('')

  useEffect(() => {
    if (occupationMode.type === OTHER) {
      dispatch(setOccupationMode(OTHER, {text: otherValue}))
    }

    if (occupationMode.type === OCCUPATION_MODE_TIME) {
      dispatch(setOccupationMode(OCCUPATION_MODE_TIME, {
        selectedDays: selectedDays,
        selectedTime: selectedTime,
      }))
    }
  }, [otherValue, selectedDays, selectedTime])

  const renderDays = () => {
    return days.map(day => {
      return (
        <span
          key={day.value}
          onClick={() => setSelectedDays(
            selectedDays.indexOf(day.value) === -1 ?
              [...selectedDays, day.value] :
              selectedDays.filter(item => item !== day.value))
          }
          className={cn(css.day, {[css.selected]: selectedDays.indexOf(day.value) !== -1})}
        >
          {day.title}
        </span>
      )
    })
  }

  const handleChangeTime = (value, start = true) => { // todo отрефакторить, работает через жопу
    const reg = /^(\d+)(.*):(\d+)(.*)$/

    let newValue = start ? selectedTime.start : selectedTime.end

    const found = value.match(reg)

    if (found !== null) {
      let hours = Number(found[1])
      let minutes = Number(found[3])

      hours = (hours > 24) ? 24 : ((hours < 0) ? 0 : hours)
      minutes = (minutes > 59) ? 59 : ((minutes < 0) ? 0 : minutes)

      newValue = `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}`
    }

    setSelectedTime({
      ...selectedTime,
      start: start ? newValue : selectedTime.start,
      end: start ? selectedTime.end : newValue
    })
  }

  return (
    <>
      <h3>Режим занятий:</h3>

      <RadioButton
        click={() => dispatch(setOccupationMode(null))}
        selected={occupationMode.type === null}
      >
        Не выбрано
      </RadioButton>
      <RadioButton
        click={() => dispatch(setOccupationMode(OCCUPATION_MODE_ANYTIME))}
        selected={occupationMode.type === OCCUPATION_MODE_ANYTIME}
        error={error}
      >
        В любое удобное время
      </RadioButton>
      <RadioButton
        click={() => dispatch(setOccupationMode(OCCUPATION_MODE_TIME, {
          selectedDays: selectedDays,
          selectedTime: selectedTime,
        }))}
        selected={occupationMode.type === OCCUPATION_MODE_TIME}
        error={error}
      >
        <div className={css.daysWrap}>
          Занятие по:
          <div className={css.days}>
            {renderDays()}
          </div>
        </div>
        <div className={css.timeWrap}>
          , время проведения с
          <div className={css.timeContainer}>
            <TextInput
              value={selectedTime.start}
              extraSmall={true}
              setValue={(value) => handleChangeTime(value)}
            />
          </div>
          до
          <div className={css.timeContainer}>
            <TextInput
              value={selectedTime.end}
              extraSmall={true}
              setValue={(value) => handleChangeTime(value, false)}
            />
          </div>
        </div>
      </RadioButton>
      <RadioButton
        click={() => dispatch(setOccupationMode(OTHER, {text: otherValue}))}
        selected={occupationMode.type === OTHER}
        error={error}
      >
        <TextInput
          placeholder={'Другой вариант'}
          value={otherValue}
          setValue={(value) => setOtherValue(value)}
          error={error}
        />
      </RadioButton>
    </>
  )
}

export default OccupationMode
