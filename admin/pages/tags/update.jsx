import React, { useEffect, useState } from 'react'
import { useHistory } from 'react-router-dom'
import {TAG_INDEX} from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { hideLoader, showLoader, setTitle, setBreacrumbs } from '../../redux/actions'

import TagForm from './form'
import NotFound from '../../components/not-found/not-found'
import Portlet from '../../components/portlet/portlet'


const TagUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список тегов',
        link: '/tag',
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [notFound, setNotFound] = useState(false)
  const [name, setName] = useState('')
  const [sort, setSort] = useState(0)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(`/api/admin/tag/${match.params.id}`)
      .then(({data}) => {
        setName(data.name)
        setSort(data.sort)
        dispatch(setTitle(`Редактирование тега "${data.name}"`))
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(TAG_INDEX)
      })
  }, [])

  const save = () => {
    const tag = {
      id: match.params.id,
      name: name,
      sort: sort
    }

    setDisableButton(true)

    axios.put('/api/admin/tag/', tag)
      .then(() => history.push(TAG_INDEX))
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

export default TagUpdate
