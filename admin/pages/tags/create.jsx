import React, {useState} from 'react'
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs'
import PanelTitle from '../../components/panel/panel-title'
import TagForm from './form'
import {TextInput, NumberInput, SaveButton} from '../../components/ui/inputs'
import {Redirect} from 'react-router'
import axios from 'axios'

const breadcrumbs = [
  {
    title: 'Главная',
    link: '/',
  },
  {
    title: 'Список тегов',
    link: '/tag',
  },
  {
    title: 'Создание тега',
    link: null,
  }
]

const TagCreate = () => {
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
      <Redirect to="/tag" />
    )
  }

  return (
    <div>
      <Breadcrumbs items={breadcrumbs}/>

      <div className="portlet w-50">
        <PanelTitle
          title={'Создание тега'}
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

export default TagCreate
