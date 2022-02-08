import React, { useState } from 'react'

import css from './scss/calendar.scss?module'
import cn from 'classnames'

const months = [
  'Январь',
  'Февраль',
  'Март',
  'Апрель',
  'Май',
  'Июнь',
  'Июль',
  'Август',
  'Сентябрь',
  'Октябрь',
  'Ноябрь',
  'Декабрь',
]

const Calendar = ({selectedDays, setSelectedDays}) => {
  const [currentMonth, setCurrentMonth] = useState(new Date())

  const updateCurrentMonth = (value) => {
    let newCurrentMonth = new Date(currentMonth)
    newCurrentMonth.setMonth(currentMonth.getMonth() + value)
    setCurrentMonth(newCurrentMonth)
  }

  const renderEmptyDays = () => {
    let month = new Date(currentMonth)
    month.setDate(1)

    const emptyDays = month.getDay() === 0 ? 6 : month.getDay() - 1

    return [...Array(emptyDays).keys()].map(item => {
      return <span key={item} className={css.day}></span>
    })
  }

  const isDaySelected = (day) => {
    return selectedDays.filter(value => {
      return value.getFullYear() === currentMonth.getFullYear() && value.getMonth() === currentMonth.getMonth() && value.getDate() === day
    }).length > 0
  }

  const handleClick = (day) => {
    if (isDaySelected(day)) {
      setSelectedDays(selectedDays.filter(value => {
        return !(value.getFullYear() === currentMonth.getFullYear() && value.getMonth() === currentMonth.getMonth() && value.getDate() === day)
      }))
    } else {
      setSelectedDays([...selectedDays, new Date(currentMonth.getFullYear(), currentMonth.getMonth(), day)])
    }
  }

  const renderDays = () => {
    const days = new Date(currentMonth.getFullYear(), currentMonth.getMonth() + 1, 0).getDate()
    return [...Array(days).keys()].map(item => {
      return (
        <span
          key={item}
          className={css.day}
          onClick={() => handleClick(item + 1)}
        >
          <span className={cn({[css.selected]: isDaySelected(item + 1)})}>
            {item + 1}
          </span>
        </span>
      )
    })
  }

  return (
    <div className={css.calendar}>
      <div className={css.header}>
        <span
          onClick={() => updateCurrentMonth(-1)}
          className={css.arrowLeft}
        ></span>
        <span className={css.title}>{months[currentMonth.getMonth()]} {currentMonth.getFullYear()}</span>
        <span
          onClick={() => updateCurrentMonth(1)}
          className={css.arrowRight}
        ></span>
      </div>
      <div className={css.body}>
        <div className={css.bodyHeader}>
          <span>пн</span>
          <span>вт</span>
          <span>ср</span>
          <span>чт</span>
          <span>пт</span>
          <span>сб</span>
          <span>вс</span>
        </div>
        <div className={css.days}>
          {renderEmptyDays()}
          {renderDays()}
        </div>
      </div>
    </div>
  )
}

export default Calendar
