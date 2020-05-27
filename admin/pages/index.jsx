import React, { useEffect } from 'react'
import { setBreacrumbs, setTitle } from '../redux/actions'
import { useDispatch} from 'react-redux'

const IndexPage = () => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(setTitle('Главная страница'))
    dispatch(setBreacrumbs([], false))
  }, [])

  return (
    <div>Добро пожаловать в Skill Grad!</div>
  )
}

export default IndexPage
