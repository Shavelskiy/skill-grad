import React, { useState, useEffect } from 'react'
import { PROGRAM_INCLUDE_INDEX } from '../../utils/routes'
import { CREATE_PROGRAM_INCLUDE_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ProgramIncludeForm from './form'
import CreatePageTemplate from '../../components/page-templates/create'
import Portlet from '../../components/portlet/portlet'


const ProgramIncludeCreate = () => {
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
    dispatch(setTitle('Добавление включено в курс'))
    dispatch(setBreacrumbs([
      {
        title: 'Включено в курс',
        link: PROGRAM_INCLUDE_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={PROGRAM_INCLUDE_INDEX}
      createUrl={CREATE_PROGRAM_INCLUDE_URL}
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
        <ProgramIncludeForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default ProgramIncludeCreate
