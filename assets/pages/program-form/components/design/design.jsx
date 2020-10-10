import React from 'react'

import { DESIGN } from '@/utils/program-form/titles'

import { useDispatch, useSelector } from 'react-redux'
import {
  selectAdditional,
  selectFormat, selectKnowLedgeCheck, setAdvantages,
  setProcessDescription
} from '../../redux/program/actions'

import { focusDesign } from './../../redux/validation/actions'

import { validateFormat, validateKnowledgeCheck, validateProgramDesign } from '@/helpers/validate-program-form'

import Block from '@/components/react-ui/program-form/block'
import SimpleRadio from '@/components/react-ui/program-form/simple-radio'
import { Textarea } from '@/components/react-ui/program-form/input'
import SimpleMultiRadio from '@/components/react-ui/program-form/simple-multi-radio'
import ProgramDesign from './program-design'

import css from './scss/design.scss?module'


const Design = () => {
  const dispatch = useDispatch()

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

  const blockActive = useSelector((state) => state.validation.design.active)
  const program = useSelector(state => state.program)

  return (
    <Block title={DESIGN} containerClass={css.container} onFocus={focusDesign}>
      <div>
        <SimpleRadio
          title={'Формат обучения'}
          options={useSelector(state => state.data.formats)}
          selectedValue={useSelector(state => state.program.format)}
          selectValue={selectFormat}
          error={blockActive && !validateFormat(program)}
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
        <ProgramDesign error={blockActive && !validateProgramDesign(program)}/>
      </div>

      <div className={css.inputContainer}>
        <SimpleRadio
          title={'Проверка знаний'}
          options={knowledgeCheck}
          selectedValue={useSelector(state => state.program.knowledgeCheck)}
          selectValue={selectKnowLedgeCheck}
          error={blockActive && !validateKnowledgeCheck(program)}
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
