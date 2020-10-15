import React, { useEffect, useState } from 'react'
import { ARTICLE_INDEX } from '../../utils/routes'

import { FETCH_ARTICLE_URL, UPDATE_ARTICLE_URL, } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ArticleForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const ArticleUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0,
    active: true,
    detailText: '',
    image: null,
    showOnMain: false,
  })

  const [uploadImage, setUploadImage] = useState(null)

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список статей',
        link: ARTICLE_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование статьи "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={ARTICLE_INDEX}
      fetchUrl={FETCH_ARTICLE_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_ARTICLE_URL}
      item={item}
      setItem={setItem}
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
          uploadImage={uploadImage}
          setUploadImage={setUploadImage}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default ArticleUpdate
