import React, { useState, useEffect } from 'react'

import axios from 'axios'

import { useDispatch, useSelector } from 'react-redux'
import { showLoader, hideLoader, setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'


const LocationView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0
  })

  useEffect(() => {
    dispatch(showLoader())

    dispatch(setBreacrumbs([
      {
        title: 'Список местополжений',
        link: '/location',
      }
    ]))

    axios.get(`/api/admin/location/${item.id}`)
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          sort: data.sort,
        })
        dispatch(setTitle(`Просмотр местоположения "${data.name}"`))
        dispatch(hideLoader())
      })
  }, [])

  return (
    <Portlet
      width={50}
      title={title}
      titleIcon={'eye'}
      withButton={false}
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
          <td>Сортировка</td>
          <td>{item.sort}</td>
        </tr>
        </tbody>
      </table>
    </Portlet>
  )
}

export default LocationView