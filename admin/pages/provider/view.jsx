import React, { useState, useEffect } from 'react'
import { CATEGORY_VIEW, LOCATION_VIEW, PROVIDER_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_PROVIDER_URL } from '../../utils/api/endpoints'
import { Link } from 'react-router-dom'


const ProviderView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    description: '',
    categories: [],
    location: null,
    organizationName: '',
    legalAddress: '',
    mailingAddress: '',
    balance: 0.0,
    ITN: '',
    IEC: '',
    PSRN: '',
    OKPO: '',
    checkingAccount: '',
    correspondentAccount: '',
    BIC: '',
    bank: '',
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список провайдеров',
        link: PROVIDER_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр провайдера "${item.name}"`))
  }, [item])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      name: data.name,
      description: data.description,
      image: data.image,
      categories: data.categories,
      location: data.location,
      organizationName: data.organizationName,
      legalAddress: data.legalAddress,
      mailingAddress: data.mailingAddress,
      balance: data.balance,
      ITN: data.ITN,
      IEC: data.IEC,
      PSRN: data.PSRN,
      OKPO: data.PSRN,
      checkingAccount: data.checkingAccount,
      correspondentAccount: data.correspondentAccount,
      BIC: data.BIC,
      bank: data.bank,
    })
  }

  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_PROVIDER_URL.replace(':id', item.id)}
      setItem={setItemFromResponse}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'eye'}
      >
        <table>
          <tbody>
          <tr>
            <td>ID</td>
            <td>{item.id}</td>
          </tr>
          <tr>
            <td>Название</td>
            <td>{item.name}</td>
          </tr>
          <tr>
            <td>Описание</td>
            <td>{item.name}</td>
          </tr>
          <tr>
            <td>Изображение</td>
            <td><img src={item.image}/></td>
          </tr>
          <tr>
            <td>Баланс</td>
            <td>{item.balance}</td>
          </tr>
          </tbody>
        </table>
        <h5>Категории</h5>
        <table>
          <thead>
          <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Тип</td>
          </tr>
          </thead>
          <tbody>
          {
            item.categories.map((item, key) => (
              <tr key={key}>
                <td>{item.id}</td>
                <td><Link to={CATEGORY_VIEW.replace(':id', item.id)}>{item.name}</Link></td>
                <td>{item.sort}</td>
              </tr>
            ))
          }
          </tbody>
        </table>
        <h5>Местоположение</h5>
        <table>
          <thead>
          <tr>
            <td>ID</td>
            <td>Название</td>
          </tr>
          </thead>
          <tbody>
          {
            item.location !== null ?
              <tr key={key}>
                <td>{item.location.id}</td>
                <td><Link to={LOCATION_VIEW.replace(':id', item.location.id)}>{item.location.title}</Link></td>
              </tr> : <></>
          }
          </tbody>
        </table>
      </Portlet>
      <Portlet
        width={50}
        title={'Реквизиты провадера'}
        titleIcon={'eye'}
      >
        <table>
          <tbody>
          <tr>
            <td>Наименование организации</td>
            <td>{item.organizationName}</td>
          </tr>
          <tr>
            <td>Юридический адрес</td>
            <td>{item.legalAddress}</td>
          </tr>
          <tr>
            <td>Почтовый адрес</td>
            <td>{item.mailingAddress}</td>
          </tr>
          <tr>
            <td>ИНН</td>
            <td>{item.ITN}</td>
          </tr>
          <tr>
            <td>КПП</td>
            <td>{item.IEC}</td>
          </tr>
          <tr>
            <td>ОГРН</td>
            <td>{item.PSRN}</td>
          </tr>
          <tr>
            <td>ОКПО</td>
            <td>{item.OKPO}</td>
          </tr>
          <tr>
            <td>Расчетный счет</td>
            <td>{item.checkingAccount}</td>
          </tr>
          <tr>
            <td>Корреспондентский счет</td>
            <td>{item.correspondentAccount}</td>
          </tr>
          <tr>
            <td>БИК</td>
            <td>{item.BIC}</td>
          </tr>
          <tr>
            <td>Банк</td>
            <td>{item.bank}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
    </ViewPageTemplate>
  )
}

export default ProviderView
