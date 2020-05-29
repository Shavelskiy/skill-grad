import React from 'react'
import { TAG_CREATE } from '../../utils/routes'

import { FETCH_TAGS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'


const table = [
  {
    title: 'Id',
    name: 'id',
  },
  {
    title: 'Название',
    name: 'name',
  },
  {
    title: 'Сортировка',
    name: 'sort',
  }
]

const actions = [
  {
    type: 'view',
    link: '/tag',
  },
  {
    type: 'update',
    link: '/tag',
  },
  {
    type: 'delete',
    link: '/api/admin/tag/',
  }
]

const TagsIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список тегов'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_TAGS_URL}
      canCreate={true}
      createLink={TAG_CREATE}
    />
  )
}

export default TagsIndex
