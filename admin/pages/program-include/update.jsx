import React, { useEffect, useState } from 'react'
import { PROGRAM_INCLUDE_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ProgramIncludeForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'
import { FETCH_PROGRAM_INCLUDE_URL, UPDATE_PROGRAM_INCLUDE_URL } from '../../utils/api/endpoints'


const ProgramIncludeUpdate = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0,
    active: true,
  })

  const [disableButton, setDisableButton] = useState(false)
  const [needSave, setNeedSave] = useState(false)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Включено в курс',
        link: PROGRAM_INCLUDE_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование включено в курс "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={PROGRAM_INCLUDE_INDEX}
      fetchUrl={FETCH_PROGRAM_INCLUDE_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PROGRAM_INCLUDE_URL}
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
        <ProgramIncludeForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default ProgramIncludeUpdate
