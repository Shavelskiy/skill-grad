import React, { useEffect } from 'react'
import NotFound from '../../components/not-found/not-found'
import { useDispatch } from 'react-redux'
import { setBreacrumbs, setTitle } from '../../redux/actions'

const NotFoundPage = (props) => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(setTitle('Ошибка 404'))
  }, [])

  return (
    <NotFound/>
  )
}

export default NotFoundPage
