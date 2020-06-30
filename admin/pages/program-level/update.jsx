import React, { useEffect, useState } from 'react'
import { PROGRAM_LEVEL_INDEX } from '../../utils/routes'

import { FETCH_PROGRAM_LEVEL_URL, UPDATE_PROGRAM_LEVEL_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setBreacrumbs, setTitle } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ProgramLevelForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const ProgramLevelUpdate = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0,
  })

  const [disableButton, setDisableButton] = useState(false)
  const [needSave, setNeedSave] = useState(false)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список уровней',
        link: PROGRAM_LEVEL_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование уровня программы обучения "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={PROGRAM_LEVEL_INDEX}
      fetchUrl={FETCH_PROGRAM_LEVEL_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PROGRAM_LEVEL_URL}
      item={item}
      setItem={setItem}
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
    </UpdatePageTemplate>
  )
}

export default ProgramLevelUpdate
