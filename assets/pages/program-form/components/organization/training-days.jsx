import React, { useState, useEffect } from 'react'

import { useDispatch, useSelector } from 'react-redux'

import Calendar from '@/components/react-ui/program-form/calendar'
import RadioButton from '@/components/react-ui/program-form/radio-button'

import css from './scss/training-days.scss?module'
import {
  TRAINING_DATE_ANYTIME,
  TRAINING_DATE_AS_THE_GROUP_FORM,
  TRAINING_DATE_CALENDAR,
  TRAINING_DATE_REQUEST
} from '@/utils/program-form/field-types'
import { setTrainingDate } from '../../redux/program/actions'


const TrainingDays = ({error = false}) => {
  const dispatch = useDispatch()

  const programId =  useSelector(state => state.program.id)

  const [selectedDays, setSelectedDays] = useState([])
  const trainingDays = useSelector(state => state.program.trainingDate)

  useEffect(() => {
    if (trainingDays.type === TRAINING_DATE_CALENDAR) {
      setSelectedDays(trainingDays.extra.map(item => new Date(item)))
    }
  }, [programId])

  useEffect(() => {
    if (trainingDays.type === TRAINING_DATE_CALENDAR) {
      dispatch(setTrainingDate(TRAINING_DATE_CALENDAR, selectedDays))
    }
  }, [selectedDays])

  return (
    <>
      <h3>Даты обучения:</h3>

      <RadioButton
        click={() => dispatch(setTrainingDate(null))}
        selected={trainingDays.type === null}
      >
        Не выбрано
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTrainingDate(TRAINING_DATE_CALENDAR, selectedDays))}
        selected={trainingDays.type === TRAINING_DATE_CALENDAR}
        error={error}
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
        click={() => dispatch(setTrainingDate(TRAINING_DATE_ANYTIME))}
        selected={trainingDays.type === TRAINING_DATE_ANYTIME}
        error={error}
      >
        В любое время
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTrainingDate(TRAINING_DATE_AS_THE_GROUP_FORM))}
        selected={trainingDays.type === TRAINING_DATE_AS_THE_GROUP_FORM}
        error={error}
      >
        По мере формирования группы
      </RadioButton>
      <RadioButton
        click={() => dispatch(setTrainingDate(TRAINING_DATE_REQUEST))}
        selected={trainingDays.type === TRAINING_DATE_REQUEST}
        error={error}
      >
        Направить запрос
      </RadioButton>
    </>
  )
}

export default TrainingDays
