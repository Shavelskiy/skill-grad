import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { PROGRAM_FORMAT_INDEX } from '../../utils/routes'

import axios from 'axios'
import { CREATE_PROGRAM_FORMAT_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showAlert } from '../../redux/actions'

import ProgramFormatForm from './form'
import Portlet from '../../components/portlet/portlet'


const ProgramFormatCreate = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setTitle('Добавление формы программы обучение'))
    dispatch(setBreacrumbs([
      {
        title: 'Формы обучения',
        link: PROGRAM_FORMAT_INDEX,
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    sort: 0,
    active: true,
  })

  const [disableButton, setDisableButton] = useState(false)

  const save = () => {
    setDisableButton(true)

    axios.post(CREATE_PROGRAM_FORMAT_URL, item)
      .then(() => history.push(PROGRAM_FORMAT_INDEX))
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
      <ProgramFormatForm
        item={item}
        setItem={setItem}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default ProgramFormatCreate
