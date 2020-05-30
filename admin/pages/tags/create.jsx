import React, { useState, useEffect } from 'react'
import PanelTitle from '../../components/panel/panel-title'
import TagForm from './form'
import { TextInput, NumberInput, SaveButton } from '../../components/ui/inputs'
import { Redirect } from 'react-router'
import axios from 'axios'
import { useDispatch, useSelector } from 'react-redux'
import { setTitle, setBreacrumbs } from '../../redux/actions'

const TagCreate = () => {
  const dispatch = useDispatch()

  useEffect(() => {
    dispatch(setTitle('Создание тега'))
    dispatch(setBreacrumbs([
      {
        title: 'Список тегов',
        link: '/tag',
      }
    ]))
  }, [])

  const title = useSelector(state => state.title)

  const [name, setName] = useState('')
  const [sort, setSort] = useState(0)
  const [redirect, setRedirect] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  const save = () => {
    const tag = {
      name: name,
      sort: sort
    }

    setDisableButton(true)

    axios.post('/api/admin/tag/', tag)
      .then(() => setRedirect(true))
  }

  if (redirect) {
    return (
      <Redirect to="/tag"/>
    )
  }

  return (
    <div className="portlet w-50">
      <PanelTitle
        title={title}
        icon={'fa fa-info'}
        withButton={false}
      />

      <div className="body">
        <TagForm
          name={name}
          setName={setName}
          sort={sort}
          setSort={setSort}
          save={save}
          disable={disableButton}
        />
      </div>
    </div>
  )
}

export default TagCreate
