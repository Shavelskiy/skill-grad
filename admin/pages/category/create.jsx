import React, { useState, useEffect } from 'react'
import { CATEGORY_INDEX } from '../../utils/routes'

import axios from 'axios'
import { CREATE_CATEGORY_URL, FETCH_CATEGORY_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs, showLoader, hideLoader, showAlert } from '../../redux/actions'

import CategoryForm from './form'
import Portlet from '../../components/portlet/portlet'
import CreatePageTemplate from '../../components/page-templates/create'


const CategoryCreate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [parentCategory, setParentCategory] = useState(null)

  const [item, setItem] = useState({
    name: '',
    slug: '',
    sort: 0,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Создание категории'))
    dispatch(setBreacrumbs([
      {
        title: 'Список категорий',
        link: CATEGORY_INDEX,
      }
    ]))

    if (typeof match.params.id !== 'undefined') {
      dispatch(showLoader())

      axios.get(FETCH_CATEGORY_URL.replace(':id', match.params.id))
        .then(({data}) => {
          setParentCategory(data)
          dispatch(hideLoader())
        })
    }
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={CATEGORY_INDEX}
      createUrl={CREATE_CATEGORY_URL.replace(':id', (parentCategory !== null) ? parentCategory.id : '')}
      item={item}
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
          parentCategory={parentCategory}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default CategoryCreate
