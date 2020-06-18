import React, { useState, useEffect } from 'react'
import { LOCATION_INDEX, LOCATION_VIEW, LOCATION_CREATE } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_LOCATION_URL } from '../../utils/api/endpoints'
import { Link } from 'react-router-dom'


const LocationView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    code: '',
    sort: 0,
    type: null,
    showInList: false,
    parentLocations: [],
    childLocations: [],
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список местоположений',
        link: LOCATION_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр метоположения "${item.name}"`))
  }, [item])

  useEffect(() => {
    setItem({...item, id: match.params.id})
  }, [match.params.id])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      name: data.name,
      code: data.code,
      sort: data.sort,
      type: data.typeLang,
      showInList: data.showInList,
      parentLocations: data.parentLocations,
      childLocations: data.childLocations,
    })
  }

  const renderLocationsList = (items, title) => {
    if (items.length < 1) {
      return <></>
    }

    return (
      <Portlet
        width={50}
        title={title}
        titleIcon={'list'}
      >
        <table>
          <thead>
          <tr>
            <td>ID</td>
            <td>Название</td>
            <td>Сортировка</td>
            <td>Тип</td>
          </tr>
          </thead>
          <tbody>{
            items.map((item, key) => (
                <tr key={key}>
                  <td>{item.id}</td>
                  <td><Link to={LOCATION_VIEW.replace(':id', item.id)}>{item.name}</Link></td>
                  <td>{item.sort}</td>
                  <td>{item.type}</td>
                </tr>
              )
            )
          }</tbody>
        </table>
      </Portlet>
    )
  }

  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_LOCATION_URL.replace(':id', item.id)}
      setItem={setItemFromResponse}
    >
      <Portlet
        width={50}
        title={title}
        titleIcon={'eye'}
        withButton={true}
        buttonText={'Добавить дочернее местоположение'}
        buttonLink={LOCATION_CREATE.replace(':id', item.id)}
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
            <td>Тип</td>
            <td>{item.type}</td>
          </tr>
          <tr>
            <td>Символьный код</td>
            <td>{item.code}</td>
          </tr>
          <tr>
            <td>Сортировка</td>
            <td>{item.sort}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
      {renderLocationsList(item.childLocations, 'Спискок дочерних метоположений')}
      {renderLocationsList(item.parentLocations, 'Спискок родительских метоположений')}

    </ViewPageTemplate>
  )
}

export default LocationView
