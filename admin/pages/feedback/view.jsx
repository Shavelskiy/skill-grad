import React, { useState, useEffect } from 'react'
import { FEEDBACK_INDEX } from '../../utils/routes'

import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

import Portlet from '../../components/portlet/portlet'
import ViewPageTemplate from '../../components/page-templates/view'
import { FETCH_FEEDBACK_ITEM_URL } from '../../utils/api/endpoints'
import dateFormat from '../../helpers/date-fromater'


const FeedbackView = ({match}) => {
  const dispatch = useDispatch()

  const title = useSelector(state => state.title)

  const [item, setItem] = useState({
    id: match.params.id,
    authorName: '',
    email: '',
    text: '',
    createdAt: new Date(),
  })

  useEffect(() => {
    dispatch(setBreacrumbs([
      {
        title: 'Список вопрсов',
        link: FEEDBACK_INDEX,
      }
    ]))
  }, [])

  useEffect(() => {
    dispatch(setTitle(`Просмотр вопроса от "${item.authorName}"`))
  }, [item])

  useEffect(() => {
    setItem({...item, id: match.params.id})
  }, [match.params.id])

  const setItemFromResponse = (data) => {
    setItem({
      id: data.id,
      authorName: data.author_name,
      email: data.email,
      text: data.text,
      createdAt: new Date(data.created_at)
    })
  }

  return (
    <ViewPageTemplate
      key={item.id}
      fetchUrl={FETCH_FEEDBACK_ITEM_URL.replace(':id', item.id)}
      setItem={setItemFromResponse}
    >
      <Portlet
        width={100}
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
            <td>Автор</td>
            <td>{item.authorName}</td>
          </tr>
          <tr>
            <td>Email</td>
            <td>{item.email}</td>
          </tr>
          <tr>
            <td>Дата вопроса</td>
            <td>{dateFormat(item.createdAt)}</td>
          </tr>
          <tr>
            <td>Текст</td>
            <td>{item.text}</td>
          </tr>
          </tbody>
        </table>
      </Portlet>
    </ViewPageTemplate>
  )
}

export default FeedbackView
