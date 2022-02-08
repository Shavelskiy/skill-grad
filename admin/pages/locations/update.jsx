import React, { useEffect, useState } from 'react'
import { LOCATION_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import LocationForm from './form'
import { FETCH_LOCATION_URL, UPDATE_LOCATION_URL } from '../../utils/api/endpoints'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const LocationUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список местоположений',
        link: LOCATION_INDEX,
      }
    ]))
  }, [])

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    code: '',
    sort: 0,
    type: null,
    showInList: false,
    parentLocation: null,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle(`Редактирование местоположения "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={LOCATION_INDEX}
      fetchUrl={FETCH_LOCATION_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_LOCATION_URL}
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
        <LocationForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default LocationUpdate
