import React, { useState, useEffect } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { showLoader, hideLoader, setTitle, setBreacrumbs } from '../../redux/actions'
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs'
import PanelTitle from '../../components/panel/panel-title'
import Table from '../../components/table/table'
import Paginator from '../../components/paginator/paginator'
import axios from 'axios'

const TagView = ({match}) => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список тегов',
        link: '/tag',
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0
  })

  useEffect(() => {
    dispatch(showLoader())
    axios.get(`/api/admin/tag/${item.id}`)
      .then(({data}) => {
        setItem({
          id: data.id,
          name: data.name,
          sort: data.sort,
        })
        dispatch(setTitle(`Просмотр тега "${data.name}"`))
        dispatch(hideLoader())
      })
  }, [])

  return (
    <div className="portlet w-50">
      <PanelTitle
        title={title}
        icon={'fa fa-eye'}
        withButton={false}
      />

      <div className="body">
        <table className="table">
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
      </div>
    </div>
  )
}

export default TagView