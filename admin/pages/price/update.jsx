import React, { useEffect, useState } from 'react'
import { PRICES_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import LocationForm from './form'
import { FETCH_PRICE_URL, UPDATE_PRICE_URL } from '../../utils/api/endpoints'
import { UpdatePageTemplate } from '../../components/page-templates/update'


const PriceUpdate = ({match}) => {
  const dispatch = useDispatch()
  const title = useSelector(state => state.title)

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список цен на платные услуги',
        link: PRICES_INDEX,
      }
    ]))
  }, [])

  const [item, setItem] = useState({
    id: match.params.id,
    title: '',
    price: 0,
    type: '',
  })

  const [needSave, setNeedSave] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  useEffect(() => {
    dispatch(setTitle(`Редактирование цены "${item.title}"`))
  }, [item])

  return (
    <UpdatePageTemplate
      indexPageUrl={PRICES_INDEX}
      fetchUrl={FETCH_PRICE_URL.replace(':id', match.params.id)}
      updateUrl={UPDATE_PRICE_URL}
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
        <LocationForm
          item={item}
          setItem={setItem}
          save={() => setNeedSave(true)}
          disable={disableButton}
        />
      </Portlet>
    </UpdatePageTemplate>
  )
}

export default PriceUpdate
