import React, { useState, useEffect } from 'react'
import { LOCATION_INDEX } from '../../utils/routes'

import { CREATE_LOCATION_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import LocationForm from './form'
import Portlet from '../../components/portlet/portlet'
import CreatePageTemplate from '../../components/page-templates/create'


const LocationCreate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    code: '',
    sort: 0,
    type: null,
    showInList: false,
    parentLocation: Number(match.params.id)
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Создание местоположения'))
    dispatch(setBreacrumbs([
      {
        title: 'Список местоположений',
        link: LOCATION_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={LOCATION_INDEX}
      createUrl={CREATE_LOCATION_URL}
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
      <LocationForm
        item={item}
        setItem={setItem}
        save={() => setNeedSave(true)}
        disable={disableButton}
      />
    </Portlet>
    </CreatePageTemplate>
  )
}

export default LocationCreate
