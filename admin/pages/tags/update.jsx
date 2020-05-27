import React, { useEffect, useState } from 'react'
import { useDispatch } from 'react-redux'
import { hideLoader, showLoader } from '../../redux/actions'
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs'
import PanelTitle from '../../components/panel/panel-title'
import TagForm from './form'
import NotFound from '../../components/not-found/not-found'
import { TextInput, NumberInput, SaveButton } from '../../components/ui/inputs'
import { Redirect } from 'react-router'
import axios from 'axios'

const TagUpdate = ({match}) => {
  const dispatch = useDispatch()

  const [notFound, setNotFound] = useState(false)
  const [name, setName] = useState('')
  const [sort, setSort] = useState(0)
  const [redirect, setRedirect] = useState(false)
  const [disableButton, setDisableButton] = useState(false)

  const getBreadcrumbs = () => {
    return [
      {
        title: 'Главная',
        link: '/',
      },
      {
        title: 'Список тегов',
        link: '/tag',
      },
      {
        title: `Редактирование тега ${name}`,
        link: null,
      }
    ]
  }

  useEffect(() => {
    dispatch(showLoader())
    axios.get(`/api/admin/tag/${match.params.id}`)
      .then(({data}) => {
        setName(data.name)
        setSort(data.sort)
        dispatch(hideLoader())
      })
      .catch((error) => {
        if (error.response && error.response.status === 404) {
          setNotFound(true)
          dispatch(hideLoader())
        }

        setRedirect(true)
      })
  }, [])

  const save = () => {
    const tag = {
      id: match.params.id,
      name: name,
      sort: sort
    }

    setDisableButton(true)

    axios.put('/api/admin/tag/', tag)
      .then(() => setRedirect(true))
  }

  if (notFound) {
    return <NotFound/>
  }

  if (redirect) {
    return (
      <Redirect to="/tag"/>
    )
  }

  return (
    <div>
      <Breadcrumbs items={getBreadcrumbs()}/>

      <div className="portlet w-50">
        <PanelTitle
          title={'Редактирование тега'}
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
    </div>
  )
}

export default TagUpdate
