import React, { useState, useEffect } from 'react'
import { FAQ_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_FAQ_URL } from '../../utils/api/endpoints'


const FaqView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    title: '',
    sort: 0,
    active: false,
    content: '',
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'FAQ',
        link: FAQ_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр FAQ "${item.title}"`))
  }, [item])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      title: data.title,
      sort: data.sort,
      active: data.active,
      content: data.content,
    })
  }

  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_FAQ_URL.replace(':id', item.id)}
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
            <td>Заголовок</td>
            <td>{item.title}</td>
          </tr>
          <tr>
            <td>Сортировка</td>
            <td>{item.sort}</td>
          </tr>
          <tr>
            <td>Активность</td>
            <td>{item.active ? 'Да' : 'Нет'}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
      <Portlet
        width={50}
        title={'Контент'}
        titleIcon={'eye'}
      >
        <div dangerouslySetInnerHTML={{__html: item.content}}></div>
      </Portlet>
    </ViewPageTemplate>
  )
}

export default FaqView
