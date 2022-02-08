import React, { useEffect, useState } from 'react'
import { CATEGORY_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import CategoryForm from './form'
import { FETCH_CATEGORY_URL, UPDATE_ARTICLE_URL } from '../../utils/api/endpoints'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const CategoryUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список категорий',
        link: CATEGORY_INDEX,
      }
    ]))
  }, [])

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    slug: '',
    sort: 0,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle(`Редактирование категории "${item.name}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={CATEGORY_INDEX}
      fetchUrl={FETCH_CATEGORY_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_ARTICLE_URL}
      item={item}
      setItem={setItem}
      setDisableButton={setDisableButton}
      needSave={needSave}
      setNeedSave={setNeedSave}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'info'}
      >
        <CategoryForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default CategoryUpdate
