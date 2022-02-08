import React from 'react'
import { ARTICLE_CREATE } from '../../utils/routes'

import { FETCH_ARTICLES_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'

const ArticleIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список статей'}
      icon={'newspaper'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_ARTICLES_URL}
      canCreate={true}
      createLink={ARTICLE_CREATE}
    />
  )
}

export default ArticleIndex
