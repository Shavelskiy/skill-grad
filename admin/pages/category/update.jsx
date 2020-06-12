import React, { useEffect, useState } from 'react'
import { useHistory } from 'react-router-dom'
import { CATEGORY_INDEX } from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { hideLoader, showLoader, setTitle, setBreacrumbs } from '../../redux/actions'

import NotFound from '../../components/not-found/not-found'
import Portlet from '../../components/portlet/portlet'
import CategoryForm from './form'
import { FETCH_CATEGORY_URL, UPDATE_CATEGORY_URL } from '../../utils/api/endpoints'


const CategoryUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список категорий',
        link: CATEGORY_INDEX,
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    slug: '',
    sort: 0,
  })

  const [notFound, setNotFound] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(FETCH_CATEGORY_URL.replace(':id', match.params.id))
      .then(({data}) => {
        setItem(data)
        dispatch(setTitle(`Редактирование категории "${data.name}"`))
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(CATEGORY_INDEX)
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    axios.put(UPDATE_CATEGORY_URL, item)
      .then(() => history.push(CATEGORY_INDEX))
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
      <CategoryForm
        item={item}
        setItem={setItem}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default CategoryUpdate
