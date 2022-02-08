import React, { useEffect, useState } from 'react'
import { PROGRAM_FORMAT_INDEX } from '../../utils/routes'

import { FETCH_PROGRAM_FORMAT_URL, UPDATE_PROGRAM_FORMAT_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setBreacrumbs, setTitle } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ProgramFormatForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const ProgramFormatUpdate = ({match}) => {
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
        title: 'Список форм программ обучения',
        link: PROGRAM_FORMAT_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование формы программы обучения "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={PROGRAM_FORMAT_INDEX}
      fetchUrl={FETCH_PROGRAM_FORMAT_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PROGRAM_FORMAT_URL}
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
        <ProgramFormatForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default ProgramFormatUpdate
