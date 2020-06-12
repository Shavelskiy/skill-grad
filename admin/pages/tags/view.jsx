import React, { useState, useEffect } from 'react'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { TAG_INDEX } from '../../utils/routes'
import { FETCH_TAG_URL } from '../../utils/api/endpoints'


const TagView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    name: '',
    sort: 0
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список тегов',
        link: TAG_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр тега "${item.name}"`))
  }, [item])

  return (
    <ViewPageTemplate
      fetchUrl={FETCH_TAG_URL.replace(':id', item.id)}
      setItem={setItem}
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
            <td>Сортировка</td>
            <td>{item.sort}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
    </ViewPageTemplate>
  )
}

export default TagView
