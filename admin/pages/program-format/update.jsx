import React, { useEffect, useState } from 'react'
import { useHistory } from 'react-router-dom'
import { ARTICLE_INDEX, PROGRAM_FORMAT_INDEX } from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { hideLoader, showLoader, setTitle, setBreacrumbs, showAlert } from '../../redux/actions'

import NotFound from '../../components/not-found/not-found'
import Portlet from '../../components/portlet/portlet'
import ProgramFormatForm from './form'
import { FETCH_PROGRAM_FORMAT_URL, UPDATE_PROGRAM_FORMAT_URL } from '../../utils/api/endpoints'


const ProgramForatmUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  const title = useSelector(state => state.title)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список форм программ обучения',
        link: ARTICLE_INDEX,
      }
    ]))
  }, [])

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0,
    active: true,
  })

  const [notFound, setNotFound] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(FETCH_PROGRAM_FORMAT_URL.replace(':id', match.params.id))
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          sort: data.sort,
          active: data.active,
        })
        dispatch(setTitle(`Редактирование формы программы обучения "${data.name}"`))
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(PROGRAM_FORMAT_INDEX)
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    axios.put(UPDATE_PROGRAM_FORMAT_URL, item)
      .then(() => history.push(PROGRAM_FORMAT_INDEX))
      .catch((error) => {
        dispatch(showAlert(error.response.data.message))
        setDisableButton(false)
      })
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
      <ProgramFormatForm
        item={item}
        setItem={setItem}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default ProgramForatmUpdate
