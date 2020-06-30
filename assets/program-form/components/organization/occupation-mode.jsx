import React, { useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setOccupationMode } from '../../redux/program/actions'

import { OCCUPATION_MODE_ANYTIME, OCCUPATION_MODE_TIME, OTHER } from '../../utils/field-types'

import RadioButton from '../ui/radio-button'
import { TextInput } from '../ui/input'

import css from './occupation-mode.scss?module'
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

const OccupationMode = () => {
  const dispatch = useDispatch()

  const occupationMode = useSelector(state => state.program.occupationMode)

  const [selectedDays, setSelectedDays] = useState([])
  const [selectedTime, setSelectedTime] = useState({
    start: '00:00',
    end: '00:00',
  })
  const [otherValue, setOtherValue] = useState('')

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
      let minuts = Number(found[3])

      hours = (hours > 24) ? 24 : ((hours < 0) ? 0 : hours)
      minuts = (minuts > 59 || minuts < 0) ? oldValues[3] : minuts

      newValue = `${hours < 10 ? '0' : ''}${hours}:${minuts < 10 ? '0' : ''}${minuts}`
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
      >
        В любое удобное время
      </RadioButton>
      <RadioButton
        click={() => dispatch(setOccupationMode(OCCUPATION_MODE_TIME, {
          selectedDays: setSelectedDays,
          selectedTime: selectedTime,
        }))}
        selected={occupationMode.type === OCCUPATION_MODE_TIME}
      >
        <div className={css.daysWrap}>
          Занятие по:
          <div className={css.days}>
            {renderDays()}
          </div>
        </div>
        <div className={css.tiemWrap}>
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
        click={() => dispatch(setOccupationMode(OTHER))}
        selected={occupationMode.type === OTHER}
      >
        <TextInput
          placeholder={'Другой вариант'}
          value={otherValue}
          setValue={(value) => setOtherValue(value, {text: otherValue})}
        />
      </RadioButton>
    </>
  )
}

export default OccupationMode
