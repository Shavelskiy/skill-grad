import React, { useEffect, useState } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setBreacrumbs, setTitle } from '../../redux/actions'

import { FAQ_INDEX } from '../../utils/routes'
import { CREATE_FAQ_URL } from '../../utils/api/endpoints'

import FaqForm from './form'
import CreatePageTemplate from '../../components/page-templates/create'
import Portlet from '../../components/portlet/portlet'


const FaqCreate = () => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    title: '',
    sort: 0,
    content: '',
    active: true,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Добавление FAQ'))
    dispatch(setBreacrumbs([
      {
        title: 'FAQ',
        link: FAQ_INDEX,
      }
    ]))
  }, [])

  return (
    <CreatePageTemplate
      indexPageUrl={FAQ_INDEX}
      createUrl={CREATE_FAQ_URL}
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
        <FaqForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </CreatePageTemplate>
  )
}

export default FaqCreate
