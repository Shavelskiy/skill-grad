import React from 'react'
import { CATEGORY_CREATE } from '../../utils/routes'

import { FETCH_CATEGORIES_URL } from '../../utils/api/endpoints'

import IndexPageTemplate from '../../components/page-templates'
import { table, actions } from './table'


const CategoryIndex = () => {
  return (
    <IndexPageTemplate
      title={'Список категорий програм обучения'}
      icon={'list'}
      table={table}
      actions={actions}
      fetchUrl={FETCH_CATEGORIES_URL}
      canCreate={true}
      createLink={CATEGORY_CREATE.replace(':id', '')}
    />
  )
}

export default CategoryIndex
