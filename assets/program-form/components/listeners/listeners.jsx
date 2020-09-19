import React from 'react'

import { LISTENERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { setLevel, setPreparations, setTargetAudience } from '../../redux/program/actions'

import Block from '../ui/block'
import EnumList from '../ui/enum-list'
import Select from '../../../components/react-ui/select'

import css from './listeners.scss?module'


const Listeners = () => {
  const dispatch = useDispatch()

  return (
    <Block title={LISTENERS} containerClass={css.container}>
      <div className={css.inputContainer}>
        <EnumList
          title={'Целевая аудитория'}
          values={useSelector(state => state.program.targetAudience)}
          setValues={(values) => dispatch(setTargetAudience(values))}
        />
      </div>

      <div className={css.levelContainer}>
        <h3>Уровень:</h3>
        <Select
          placeholder={'Выберите уровень'}
          value={useSelector(state => state.program.level)}
          setValue={(value) => dispatch(setLevel(value))}
          options={useSelector(state => state.data.levels)}
        />
      </div>

      <div>
        <EnumList
          title={'Предварительная подготовка'}
          values={useSelector(state => state.program.preparations)}
          setValues={(values) => dispatch(setPreparations(values))}
        />
      </div>
    </Block>
  )
}

export default Listeners
