import React, { useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'

import Calendar from '../ui/calendar'
import RadioButton from '../ui/radio-button'

import css from './scss/training-days.scss?module'
import {
  TRAINING_DATE_ANYTIME,
  TRAINING_DATE_AS_THE_GROUP_FORM,
  TRAINING_DATE_CALENDAR,
  TRAINING_DATE_REQUEST
} from '../../utils/field-types'
import { setTraingDate } from '../../redux/program/actions'


const TrainingDays = () => {
  const dispatch = useDispatch()

  const [selectedDays, setSelectedDays] = useState([])
  const trainingDays = useSelector(state => state.program.traningDate)

  return (
    <>
      <h3>Даты обучения:</h3>

      <RadioButton
        click={() => dispatch(setTraingDate(null))}
        selected={trainingDays.type === null}
      >
        Не выбрано
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTraingDate(TRAINING_DATE_CALENDAR, selectedDays))}
        selected={trainingDays.type === TRAINING_DATE_CALENDAR}
      >
        Выбор из календаря (можно выбрать несколько дат)
      </RadioButton>
      <div className={css.calendarContainer}>
        <Calendar
          selectedDays={selectedDays}
          setSelectedDays={setSelectedDays}
        />
      </div>
      <RadioButton
        click={() => dispatch(setTraingDate(TRAINING_DATE_ANYTIME))}
        selected={trainingDays.type === TRAINING_DATE_ANYTIME}
      >
        В любое время
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTraingDate(TRAINING_DATE_AS_THE_GROUP_FORM))}
        selected={trainingDays.type === TRAINING_DATE_AS_THE_GROUP_FORM}
      >
        По мере формирования группы
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTraingDate(TRAINING_DATE_REQUEST))}
        selected={trainingDays.type === TRAINING_DATE_REQUEST}
      >
        Направить запрос
      </RadioButton>
    </>
  )
}

export default TrainingDays
