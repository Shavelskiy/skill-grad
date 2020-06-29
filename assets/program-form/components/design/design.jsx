import React from 'react'

import { DESIGN } from '../../utils/titles'

import { useDispatch, useSelector } from 'react-redux'
import {
  selectAdditional,
  selectFormat, selectKnowLedgeCheck, setAdvantages,
  setProcessDescription
} from '../../redux/program/actions'

import Block from '../ui/block'
import SimpleRadio from '../ui/simple-radio'
import { Textarea } from '../ui/input'
import ProgramDesign from './program-design'

import css from './design.scss?module'
import SimpleMultiRadio from '../ui/simple-multi-radio'


const Design = () => {
  const dispatch = useDispatch()

  const formats = [ //todo
    {
      id: 1,
      title: 'Вебинар',
    },
    {
      id: 2,
      title: 'Онлайн курс',
    },
    {
      id: 3,
      title: 'Очная форма обучения',
    },
    {
      id: 4,
      title: 'Очно-заочная форма обучения',
    },
    {
      id: 5,
      title: 'Заочная форма обучения',
    },

    {
      id: 6,
      title: 'Смешанная форма обучения',
    },
  ]

  const knowledgeCheck = [
    {
      id: true,
      title: 'Да',
    },

    {
      id: false,
      title: 'Нет',
    },
  ]

  const additional = [
    {
      id: 1,
      title: 'Консультационная поддержка после обучения',
    },
    {
      id: 2,
      title: 'Онлайн форум выпускников',
    },
    {
      id: 3,
      title: 'Трудоустройство, практика, стажировка выпускников',
    },
  ]


  return (
    <Block title={DESIGN}>
      <div className={css.inputContainer}>
        <SimpleRadio
          title={'Формат обучения'}
          options={formats}
          selectedValue={useSelector(state => state.program.format)}
          selectValue={selectFormat}
        />
      </div>

      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Описание процесса обучения'}
          value={useSelector(state => state.program.processDescription)}
          setValue={(processDescription) => dispatch(setProcessDescription(processDescription))}
        />
      </div>

      <div className={css.inputContainer}>
        <ProgramDesign/>
      </div>

      <div className={css.inputContainer}>
        <SimpleRadio
          title={'Проверка знаний'}
          options={knowledgeCheck}
          selectedValue={useSelector(state => state.program.knowledgeCheck)}
          selectValue={selectKnowLedgeCheck}
        />
      </div>

      <div className={css.inputContainer}>
        <SimpleMultiRadio
          title={'Дополнительно'}
          options={additional}
          selectedValues={useSelector(state => state.program.additional)}
          setValues={selectAdditional}
        />
      </div>

      <div className={css.inputContainer}>
        <Textarea
          placeholder={'Преимущества программы обучения'}
          value={useSelector(state => state.program.advantages)}
          setValue={(advantages) => dispatch(setAdvantages(advantages))}
        />
      </div>
    </Block>
  )
}

export default Design
