import React, { useEffect, useState } from 'react'
import { PAGE_INDEX } from '../../utils/routes'

import { FETCH_PAGE_URL, UPDATE_PAGE_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import PageForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const PageUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    title: '',
    slug: '',
    content: '',
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Редактирование страницы'))
    dispatch(setBreacrumbs([
      {
        title: 'Страницы',
        link: PAGE_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование страницы "${item.title}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={PAGE_INDEX}
      fetchUrl={FETCH_PAGE_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PAGE_URL}
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
        <PageForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default PageUpdate
