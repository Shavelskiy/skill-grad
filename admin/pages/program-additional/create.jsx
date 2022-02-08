import React, { useState, useEffect } from 'react'
import { PROGRAM_ADDITIONAL_INDEX } from '../../utils/routes'
import { CREATE_PROGRAM_ADDITIONAL_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ProgramFormatForm from './form'
import CreatePageTemplate from '../../components/page-templates/create'
import Portlet from '../../components/portlet/portlet'


const ProgramAdditionalCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    sort: 0,
    active: true,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление дополнительных пунктов программы обучения'))
    dispatch(setBreacrumbs([
      {
        title: 'Дополнительные пункты программы обучения',
        link: PROGRAM_ADDITIONAL_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={PROGRAM_ADDITIONAL_INDEX}
      createUrl={CREATE_PROGRAM_ADDITIONAL_URL}
      item={item}
      setDisableButton={setDisableButton}
      needSave={needSave}
      setNeedSave={setNeedSave}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'info'}
      >
        <ProgramFormatForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default ProgramAdditionalCreate
