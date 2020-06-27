import React from 'react'

import { LISTENERS } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'

import Block from '../ui/block'
import EnumList from '../ui/enum-list'

import css from './listeners.scss?module'
import { setTargetAudience } from '../../redux/actions'


const Listeners = () => {
  const dispatch = useDispatch()

  return (
    <Block title={LISTENERS}>
      <div className={css.inputContainer}>
        <EnumList
          title={'Целевая аудитория'}
          values={useSelector(state => state.targetAudience)}
          setValues={(values) => dispatch(setTargetAudience(values))}
        />
      </div>
    </Block>
  )
}

export default Listeners
