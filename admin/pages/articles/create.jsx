import React, { useState, useEffect } from 'react'
import { useHistory } from 'react-router-dom'
import { ARTICLE_INDEX } from '../../utils/routes'

import axios from 'axios'
import { CREATE_ARTICLE_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showAlert } from '../../redux/actions'

import ArticuleForm from './form'
import Portlet from '../../components/portlet/portlet'


const ArticleCreate = () => {
  const dispatch = useDispatch()
  const history = useHistory()

  useEffect(() => {
    dispatch(setTitle('Добавление статьи'))
    dispatch(setBreacrumbs([
      {
        title: 'Список статей',
        link: ARTICLE_INDEX,
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    slug: '',
    sort: 0,
    detailText: '',
  })
  const [uploadImage, setUploadImage] = useState(null)

  const [disableButton, setDisableButton] = useState(false)

  const save = () => {
    setDisableButton(true)

    const formData = new FormData()
    formData.append('uploadImage', uploadImage)

    for (let key in item) {
      formData.append(key, item[key])
    }

    axios.post(CREATE_ARTICLE_URL, formData, {
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

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'info'}
    >
      <ArticuleForm
        item={item}
        setItem={setItem}
        save={save}
        uploadImage={uploadImage}
        setUploadImage={setUploadImage}
        disable={disableButton}
      />
    </Portlet>
  )
}

export default ArticleCreate
