import React, { useState, useEffect } from 'react'
import { ARTICLE_INDEX } from '../../utils/routes'

import { CREATE_ARTICLE_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import ArticleForm from './form'
import Portlet from '../../components/portlet/portlet'
import CreatePageTemplate from '../../components/page-templates/create'


const ArticleCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    name: '',
    slug: '',
    sort: 0,
    active: true,
    detailText: '',
    showOnMain: false,
  })
  const [uploadImage, setUploadImage] = useState(null)

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление статьи'))
    dispatch(setBreacrumbs([
      {
        title: 'Список статей',
        link: ARTICLE_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={ARTICLE_INDEX}
      createUrl={CREATE_ARTICLE_URL}
      item={item}
      setDisableButton={setDisableButton}
      needSave={needSave}
      setNeedSave={setNeedSave}
      multipart={true}
      appendExternalData={(formData) => formData.append('uploadImage', uploadImage)}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'info'}
      >
        <ArticleForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          uploadImage={uploadImage}
          setUploadImage={setUploadImage}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default ArticleCreate
