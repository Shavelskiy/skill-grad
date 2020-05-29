import React from 'react'
import { TAG_CREATE } from '../../utils/routes'

import { FETCH_TAGS_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { actions, table } from './table'


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
