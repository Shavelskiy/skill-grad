import React, { useEffect, useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setBreacrumbs, setTitle } from '../../redux/actions'

import { PAGE_INDEX } from '../../utils/routes'
import { CREATE_PAGE_URL } from '../../utils/api/endpoints'

import CreatePageTemplate from '../../components/page-templates/create'
import Portlet from '../../components/portlet/portlet'
import PageForm from './form'


const PageCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    title: '',
    slug: '',
    content: '',
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление страницы'))
    dispatch(setBreacrumbs([
      {
        title: 'Страницы',
        link: PAGE_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={PAGE_INDEX}
      createUrl={CREATE_PAGE_URL}
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
        <PageForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default PageCreate
