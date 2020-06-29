import React from 'react'

import { ORGANIZAITION } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import { selectInclude, setLocation } from '../../redux/program/actions'

import Block from '../ui/block'
import TrainingDays from './training-days'
import OccupationMode from './occupation-mode'
import { Textarea } from '../ui/input'
import SimpleMultiRadio from '../ui/simple-multi-radio'

import css from './organization.scss?module'


const Organization = () => {
  const dispatch = useDispatch()

  const include = [ // todo
    {
      id: 1,
      title: 'Книги',
    },
    {
      id: 2,
      title: 'Методические материалы',
    },
    {
      id: 3,
      title: 'Кофе-брейки',
    },
    {
      id: 4,
      title: 'Обеды',
    },
  ]

  return (
    <Block title={ORGANIZAITION}>
      <div className={css.inputContainer}>
        <TrainingDays/>
      </div>

      <div className={css.inputContainer}>
        <OccupationMode/>
      </div>

      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Место проведения'}
          value={useSelector(state => state.program.location)}
          setValue={(value) => dispatch(setLocation(value))}
        />
      </div>

      <div className={css.inputContainer}>
        <SimpleMultiRadio
          title={'Включено в курс:'}
          options={include}
          selectedValues={useSelector(state => state.program.include)}
          setValues={selectInclude}
        />
      </div>
    </Block>
  )
}

export default Organization
