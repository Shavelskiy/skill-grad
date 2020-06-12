import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { TAG_INDEX } from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import TagForm from './form'
import Portlet from '../../components/portlet/portlet'


const TagCreate = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setTitle('Создание тега'))
    dispatch(setBreacrumbs([
      {
        title: 'Список тегов',
        link: '/tag',
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [name, setName] = useState('')
  const [sort, setSort] = useState(0)
  const [disableButton, setDisableButton] = useState(false)

  const save = () => {
    const tag = {
      name: name,
      sort: sort
    }

    setDisableButton(true)

    axios.post('/api/admin/tag/', tag)
      .then(() => history.push(TAG_INDEX))
  }

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'info'}
    >
      <TagForm
        name={name}
        setName={setName}
        sort={sort}
        setSort={setSort}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default TagCreate
