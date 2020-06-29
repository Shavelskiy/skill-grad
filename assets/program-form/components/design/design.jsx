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

  return (
    <Block title={DESIGN} containerClass={css.container}>
      <div>
        <SimpleRadio
          title={'Формат обучения'}
          options={useSelector(state => state.data.formats)}
          selectedValue={useSelector(state => state.program.format)}
          selectValue={selectFormat}
        />
      </div>

      <div className={css.bigMargin}>
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
          options={useSelector(state => state.data.knowledgeCheck)}
          selectedValue={useSelector(state => state.program.knowledgeCheck)}
          selectValue={selectKnowLedgeCheck}
        />
      </div>

      <div className={css.inputContainer}>
        <SimpleMultiRadio
          title={'Дополнительно'}
          options={useSelector(state => state.data.additional)}
          selectedValues={useSelector(state => state.program.additional)}
          setValues={selectAdditional}
        />
      </div>

      <div className={css.bigMargin}>
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
