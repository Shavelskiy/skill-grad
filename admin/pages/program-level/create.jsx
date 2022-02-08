import React, { useState, useEffect } from 'react'
import { PROGRAM_LEVEL_INDEX } from '../../utils/routes'
import { CREATE_PROGRAM_LEVEL_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ProgramLevelForm from './form'
import CreatePageTemplate from '../../components/page-templates/create'
import Portlet from '../../components/portlet/portlet'


const ProgramLevelCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    sort: 0,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление уровня программы обучение'))
    dispatch(setBreacrumbs([
      {
        title: 'Уровни',
        link: PROGRAM_LEVEL_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={PROGRAM_LEVEL_INDEX}
      createUrl={CREATE_PROGRAM_LEVEL_URL}
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
        <ProgramLevelForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default ProgramLevelCreate
