import React, { useEffect, useState } from 'react'
import { useHistory } from 'react-router-dom'
import { LOCATION_INDEX } from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { hideLoader, showLoader, setTitle, setBreacrumbs } from '../../redux/actions'

import NotFound from '../../components/not-found/not-found'
import Portlet from '../../components/portlet/portlet'
import LocationForm from './form'
import { FETCH_LOCATION_URL, UPDATE_LOCATION_URL } from '../../utils/api/endpoints'


const LocationUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список местоположений',
        link: LOCATION_INDEX,
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    code: '',
    sort: 0,
    type: null,
    showInList: false,
    parentLocation: null,
  })

  const [notFound, setNotFound] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(FETCH_LOCATION_URL.replace(':id', match.params.id))
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          code: data.code,
          sort: data.sort,
          type: data.type,
          showInList: data.showInList,
          parentLocation: data.parentLocationId,
        })

        dispatch(setTitle(`Редактирование местоположения "${data.name}"`))
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(LOCATION_INDEX)
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    axios.put(UPDATE_LOCATION_URL, item)
      .then(() => history.push(LOCATION_INDEX))
  }

  if (notFound) {
    return <NotFound/>
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
      />
    </Portlet>
  )
}

export default LocationUpdate
