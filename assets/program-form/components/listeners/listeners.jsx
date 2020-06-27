import React from 'react'

import { LISTENERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import {setLevel, setPreparations, setTargetAudience } from '../../redux/actions'

import Block from '../ui/block'
import EnumList from '../ui/enum-list'
import Select from '../ui/select'

import css from './listeners.scss?module'
import cn from 'classnames'


const Listeners = () => {
  const dispatch = useDispatch()

  const levels = [ // todo
    {
      value: 1,
      title: 'Начальный',
    },
    {
      value: 2,
      title: 'Средний',
    },
    {
      value: 3,
      title: 'Продвинутый',
    },
  ]

  return (
    <Block title={LISTENERS}>
      <div className={css.inputContainer}>
        <EnumList
          title={'Целевая аудитория'}
          values={useSelector(state => state.targetAudience)}
          setValues={(values) => dispatch(setTargetAudience(values))}
        />
      </div>

      <div className={cn(css.inputContainer, css.levelContainer)}>
        <h3>Уровень:</h3>
        <Select
          placeholder={'Выберите уровень'}
          value={useSelector(state => state.level)}
          setValue={(value) => dispatch(setLevel(value))}
          options={levels}
        />
      </div>

      <div className={css.inputContainer}>
        <EnumList
          title={'Предварительная подготовка'}
          values={useSelector(state => state.preparations)}
          setValues={(values) => dispatch(setPreparations(values))}
        />
      </div>
    </Block>
  )
}

export default Listeners
