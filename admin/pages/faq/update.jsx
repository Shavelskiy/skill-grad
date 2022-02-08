import React, { useEffect, useState } from 'react'
import { FAQ_INDEX } from '../../utils/routes'

import { FETCH_FAQ_URL, UPDATE_FAQ_URL } from '../../utils/api/endpoints'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import FaqForm from './form'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const FaqUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    title: '',
    sort: 0,
    content: '',
    active: true,
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle('Редактирование FAQ'))
    dispatch(setBreacrumbs([
      {
        title: 'FAQ',
        link: FAQ_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Редактирование FAQ "${item.title}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={FAQ_INDEX}
      fetchUrl={FETCH_FAQ_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_FAQ_URL}
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
        <FaqForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default FaqUpdate
