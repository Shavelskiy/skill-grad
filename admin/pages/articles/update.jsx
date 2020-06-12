import React, { useEffect, useState } from 'react'
import { useHistory } from 'react-router-dom'
import { ARTICLE_INDEX } from '../../utils/routes'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { hideLoader, showLoader, setTitle, setBreacrumbs, showAlert } from '../../redux/actions'

import NotFound from '../../components/not-found/not-found'
import Portlet from '../../components/portlet/portlet'
import ArticuleForm from './form'
import { FETCH_ARTICLE_URL, UPDATE_ARTICLE_URL } from '../../utils/api/endpoints'


const ArticleUpdate = ({match}) => {
  const dispatch = useDispatch()
  const history = useHistory()

  const title = useSelector(state => state.title)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список статей',
        link: ARTICLE_INDEX,
      }
    ]))
  }, [])

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    slug: '',
    sort: 0,
    detailText: '',
    image: null,
  })

  const [uploadImage, setUploadImage] = useState(null)

  const [loaded, setLoaded] = useState(false)
  const [notFound, setNotFound] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(showLoader())
    axios.get(FETCH_ARTICLE_URL.replace(':id', match.params.id))
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          slug: data.slug,
          sort: data.sort,
          detailText: data.detail_text,
          image: data.image
        })
        dispatch(setTitle(`Редактирование категории "${data.name}"`))
        dispatch(hideLoader())
        setLoaded(true)
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        history.push(ARTICLE_INDEX)
      })
  }, [])

  const save = () => {
    setDisableButton(true)

    const formData = new FormData()
    formData.append('uploadImage', uploadImage)

    for (let key in item) {
      formData.append(key, item[key])
    }

    axios.put(UPDATE_ARTICLE_URL, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then(() => history.push(ARTICLE_INDEX))
      .catch((error) => {
        dispatch(showAlert(error.response.data.message))
        setDisableButton(false)
      })
  }

  if (notFound) {
    return <NotFound/>
  }

  if (!loaded) {
    return <></>
  }

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'info'}
    >
      <ArticuleForm
        item={item}
        setItem={setItem}
        uploadImage={uploadImage}
        setUploadImage={setUploadImage}
        save={save}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default ArticleUpdate
