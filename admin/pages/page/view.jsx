import React, { useState, useEffect } from 'react'
import { PAGE_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_PAGE_URL } from '../../utils/api/endpoints'


const PageView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    title: '',
    slug: '',
    content: '',
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Страницы',
        link: PAGE_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр страницы "${item.title}"`))
  }, [item])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      title: data.title,
      slug: data.slug,
      content: data.content,
    })
  }

  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_PAGE_URL.replace(':id', item.id)}
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
            <td>Код</td>
            <td>{item.slug}</td>
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

export default PageView
