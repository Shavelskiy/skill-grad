import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { LOCATION_INDEX } from '../../utils/routes'

import axios from 'axios'
import { CREATE_LOCATION_URL, FETCH_ALL_LOCATIONS } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showLoader, hideLoader, showAlert } from '../../redux/actions'

import LocationForm from './form'
import Portlet from '../../components/portlet/portlet'


const LocationCreate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    code: '',
    sort: 0,
    type: null,
    showInList: false,
    parentLocation: match.params.id
  })

  const [locations, setLocations] = useState([])

  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Создание местоположения'))
    dispatch(setBreacrumbs([
      {
        title: 'Список местоположений',
        link: LOCATION_INDEX,
      }
    ]))

    dispatch(showLoader())

    axios.get(FETCH_ALL_LOCATIONS)
      .then(({data}) => {
        setLocations(data.locations)
        dispatch(hideLoader())
      })
  }, [])


  const save = () => {
    setDisableButton(true)

    axios.post(CREATE_LOCATION_URL, item)
      .then(() => history.push(LOCATION_INDEX))
      .catch((error) => {
        dispatch(showAlert(error.response.data.message))
        setDisableButton(false)
      })
  }

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'info'}
    >
      <LocationForm
        item={item}
        setItem={setItem}
        save={save}
        disable={disableButton}
        locations={locations}
      />
    </Portlet>
  )
}

export default LocationCreate
